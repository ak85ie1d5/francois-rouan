/**
 * TableSortable - Script to add sorting functionality to HTML tables.
 *
 * Features:
 * 1. Tables must have the `table-sortable` class.
 * 2. Sortable column headers must have the `data-table-sortable-th` attribute (the value can be anything, it just needs to be present).
 * 3. Automatically adds `aria-sort` attributes for accessibility.
 * 4. Adds the `table-sortable-active` class to the active header.
 * 5. Works with multiple tables on the same page - each table is sorted independently.
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

        rows.sort((rowA, rowB) => {
            const cellA = rowA.getElementsByTagName("TD")[n];
            const cellB = rowB.getElementsByTagName("TD")[n];
            const valueA = this.#getCellValue(cellA);
            const valueB = this.#getCellValue(cellB);
            const comparison = valueA.localeCompare(valueB, undefined, {
                numeric: true,
                sensitivity: "base"
            });

            return dir === "asc" ? comparison : comparison * -1;
        });

        rows.forEach(row => {
            tableBody.appendChild(row);
        });

        tableHeader.removeAttribute("aria-sort-default");
        this.#addAttributeToTableHeader(tableHeader, dir);
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
