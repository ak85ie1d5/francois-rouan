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
    if (document.querySelectorAll(".table-sortable")) {
        if (document.querySelectorAll("[data-table-sortable-th]")) {
            new tableSortable;
        } else {}
    } else {}
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
     * @private
     */
    #sortTable(tableHeader) {
        let rows, i, x, y, shouldSwitch, switchcount = 0;
        let switching = true;
        // Set the sorting direction to ascending:
        let dir = "asc";

        // Find the table that contains this header
        const table = tableHeader.closest('.table-sortable');
        if (!table) return;

        // Calculate the real column index within this specific table
        const allHeadersInTable = Array.from(table.querySelectorAll('thead th[data-table-sortable-th]'));
        const n = allHeadersInTable.indexOf(tableHeader);

        if (n === -1) return; // Header not found in this table

        // Delete the attributes of other th in THIS table only
        allHeadersInTable.forEach(header => {
            if (header !== tableHeader) {
                this.#removeAttributeToTableHeader(header);
            }
        });

        // Make a loop that will continue until no switching has been done:
        while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            // Loop through all table rows (except the first, which contains table headers):
            for (i = 1; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];

                // Skip if cells don't exist
                if (!x || !y) continue;

                // Check if the two rows should switch place, based on the direction, asc or desc:
                if (dir === "asc" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    this.#addAttributeToTableHeader(tableHeader, dir);
                    break;
                } else if (dir === "desc" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    this.#addAttributeToTableHeader(tableHeader, dir);
                    break;
                }
            }
            if (shouldSwitch) {

                // If a switch has been marked, make the switch and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount ++;
            } else {
                // If no switching has been done AND the direction is "asc", set the direction to "desc" and run the while loop again.
                if (switchcount === 0 && dir === "asc") {

                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
}
