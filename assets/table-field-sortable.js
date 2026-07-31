/**
 * TableSortable - Script to add sorting functionality to HTML tables.
 *
 * Features:
 * 1. Tables must have the `table-sortable` class.
 * 2. Sortable column headers must have the `data-table-sortable-th` attribute (the value can be anything, it just needs to be present).
 * 3. Automatically adds `aria-sort` attributes for accessibility.
 * 4. Adds the `table-sortable-active` class to the active header.
 * 5. Works with multiple tables on the same page - each table is sorted independently.
 * 6. Supports cascading sort: a header carrying `aria-sort-<level>="asc|desc"` becomes a tie-breaker,
 *    applied after the sorted column when its values are equal. Levels are applied in ascending order
 *    (`aria-sort-1` before `aria-sort-2`) and each tie-breaker keeps its own direction, whatever the
 *    direction of the sorted column. `aria-sort-default` is not a level, it designates the column
 *    sorted on page load.
 *
 * Example usage in the DOM:
 * <table class="table-sortable">
 *   <thead>
 *     <tr>
 *       <th data-table-sortable-th="0">Name</th>
 *       <th data-table-sortable-th="1">Age</th>
 *       <th data-table-sortable-th="2">City</th>
 *     </tr>
 *   </thead>
 *   <tbody>
 *     ...
 *   </tbody>
 * </table>
 *
 * Instructions:
 * 1. Include the `table-sortable.js` file in your project.
 * 2. Add the `table-sortable` class to tables you want to make sortable.
 * 3. Add the `data-table-sortable-th` attribute to sortable column headers (any unique value works).
 * 4. Sorting is automatically enabled on page load.
 * 5. The script automatically calculates the real column index within each table.
 */
document.addEventListener('DOMContentLoaded', function () {
    if (
        document.querySelectorAll(".table-sortable").length &&
        document.querySelectorAll("[data-table-sortable-th]").length
    ) {
        new tableSortable();
    }
})

/**
 * Class representing a sortable table.
 */
class tableSortable {
    /**
     * Initializes the tableSortable instance.
     * Selects all sortable tables and their headers, and sets up event listeners.
     */
    constructor() {
        this.tables = document.querySelectorAll(".table-sortable");
        let tableHeaders = document.querySelectorAll("[data-table-sortable-th]");
        this.#getTableHeaders(tableHeaders);
        this.#sortDefaultTableHeaders();
    }

    /**
     * Adds click event listeners to all table headers.
     *
     * @param {NodeList} tableHeaders - A list of table header elements with the "data-table-sortable-th" attribute.
     * @private
     */
    #getTableHeaders(tableHeaders) {
        tableHeaders.forEach(tableHeader => {
            tableHeader.addEventListener("click", () => {
                this.#sortTable(tableHeader);
            });
        });
    }

    /**
     * Sorts tables on page load using headers with the "aria-sort-default" attribute.
     *
     * @private
     */
    #sortDefaultTableHeaders() {
        document.querySelectorAll("[data-table-sortable-th][aria-sort-default]").forEach(tableHeader => {
            const sortableDirection = tableHeader.getAttribute("aria-sort-default");

            if (sortableDirection === "asc" || sortableDirection === "desc") {
                this.#sortTable(tableHeader, sortableDirection);
            }
        });
    }

    /**
     * Adds the "aria-sort" attribute and "table-sortable-active" class to the specified table header.
     *
     * @param {HTMLElement} tableHeader - The table header element to update.
     * @param {string} sortableDirection - The sorting direction ("asc" or "desc").
     * @private
     */
    #addAttributeToTableHeader(tableHeader, sortableDirection) {
        tableHeader.classList.add("table-sortable-active");
        tableHeader.setAttribute("aria-sort", sortableDirection);
    }

    /**
     * Removes the "aria-sort" attribute, "aria-sort-default" attribute, and "table-sortable-active" class from the specified table header.
     *
     * @param {HTMLElement} tableHeader - The table header element to update.
     * @private
     */
    #removeAttributeToTableHeader(tableHeader) {
        tableHeader.classList.remove("table-sortable-active");
        tableHeader.removeAttribute("aria-sort");
        tableHeader.removeAttribute("aria-sort-default");
    }

    /**
     * Sorts the table rows based on the specified column index.
     * Updates the attributes and classes of the table headers to reflect the sorting state.
     *
     * @param {HTMLElement} tableHeader - The table header element that was clicked.
     * @param {string|null} sortableDirection - The forced sorting direction ("asc" or "desc").
     * @private
     */
    #sortTable(tableHeader, sortableDirection = null) {
        // Find the table that contains this header
        const table = tableHeader.closest('.table-sortable');
        if (!table) return;

        // Calculate the real column index within this specific table
        const allHeadersInTable = table.tHead ? Array.from(table.tHead.querySelectorAll('th')) : [];
        const sortableHeadersInTable = allHeadersInTable.filter(header => header.hasAttribute("data-table-sortable-th"));
        const n = allHeadersInTable.indexOf(tableHeader);

        if (n === -1) return; // Header not found in this table

        // Delete the attributes of other th in THIS table only
        sortableHeadersInTable.forEach(header => {
            if (header !== tableHeader) {
                this.#removeAttributeToTableHeader(header);
            }
        });

        const tableBody = table.tBodies[0];
        if (!tableBody) return;

        const rows = Array.from(tableBody.rows);
        const dir = sortableDirection || (tableHeader.getAttribute("aria-sort") === "asc" ? "desc" : "asc");
        const sortColumns = this.#getSortColumns(allHeadersInTable, n, dir);

        rows.sort((rowA, rowB) => {
            for (const sortColumn of sortColumns) {
                const comparison = this.#compareCells(rowA, rowB, sortColumn.index);

                if (comparison !== 0) {
                    return sortColumn.direction === "asc" ? comparison : comparison * -1;
                }
            }

            return 0;
        });

        rows.forEach(row => {
            tableBody.appendChild(row);
        });

        tableHeader.removeAttribute("aria-sort-default");
        this.#addAttributeToTableHeader(tableHeader, dir);
    }

    /**
     * Builds the ordered list of columns used to sort the table.
     * The clicked column comes first, then the tie-breaker columns declared with
     * "aria-sort-1", "aria-sort-2", ... in ascending level order. Each tie-breaker keeps
     * its own declared direction, only the clicked column follows the toggled direction.
     *
     * @param {HTMLElement[]} allHeadersInTable - Every header of the table being sorted.
     * @param {number} columnIndex - The index of the clicked column.
     * @param {string} sortableDirection - The sorting direction of the clicked column ("asc" or "desc").
     * @returns {{index: number, direction: string}[]}
     * @private
     */
    #getSortColumns(allHeadersInTable, columnIndex, sortableDirection) {
        const sortColumns = [{index: columnIndex, direction: sortableDirection}];

        allHeadersInTable
            .map((header, index) => ({index: index, level: this.#getSortLevel(header), header: header}))
            .filter(tieBreaker => tieBreaker.level !== null)
            .sort((tieBreakerA, tieBreakerB) => tieBreakerA.level - tieBreakerB.level)
            .forEach(tieBreaker => {
                if (sortColumns.some(sortColumn => sortColumn.index === tieBreaker.index)) {
                    return;
                }

                const direction = tieBreaker.header.getAttribute(`aria-sort-${tieBreaker.level}`);

                sortColumns.push({
                    index: tieBreaker.index,
                    direction: direction === "asc" ? "asc" : "desc"
                });
            });

        return sortColumns;
    }

    /**
     * Returns the tie-breaker level of a header, read from its "aria-sort-<level>" attribute.
     * "aria-sort-default" is not a level and is ignored here.
     *
     * @param {HTMLElement} tableHeader - The header to inspect.
     * @returns {number|null}
     * @private
     */
    #getSortLevel(tableHeader) {
        for (const attribute of tableHeader.attributes) {
            const matches = attribute.name.match(/^aria-sort-(\d+)$/);

            if (matches) {
                return parseInt(matches[1], 10);
            }
        }

        return null;
    }

    /**
     * Compares two rows on a single column, ignoring the sorting direction.
     *
     * @param {HTMLElement} rowA - The first row to compare.
     * @param {HTMLElement} rowB - The second row to compare.
     * @param {number} columnIndex - The index of the column to compare.
     * @returns {number}
     * @private
     */
    #compareCells(rowA, rowB, columnIndex) {
        const valueA = this.#getCellValue(rowA.getElementsByTagName("TD")[columnIndex]);
        const valueB = this.#getCellValue(rowB.getElementsByTagName("TD")[columnIndex]);

        return valueA.localeCompare(valueB, undefined, {
            numeric: true,
            sensitivity: "base"
        });
    }

    /**
     * Returns the comparable value of a table cell.
     *
     * @param {HTMLElement|null} tableCell - The cell to read.
     * @returns {string}
     * @private
     */
    #getCellValue(tableCell) {
        if (!tableCell) {
            return "";
        }

        const field = tableCell.querySelector("input, select, textarea");

        if (field) {
            return field.value.trim();
        }

        return tableCell.textContent.trim();
    }
}
