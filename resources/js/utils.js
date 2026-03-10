/**
 * Formats a number as a price with custom separators.
 * e.g., 12345.67 -> $12.345,67
 * @param {number} price
 * @returns {string|number}
 */
export const formatPrice = (price) => {
    const numberPrice = Number(price);
    if (isNaN(numberPrice)) {
        return price; // Return original value if it's not a valid number
    }

    // Using German locale ('de-DE') as it uses '.' for thousands and ',' for decimals.
    return new Intl.NumberFormat('de-DE', {
        style: 'currency',
        currency: 'USD', // You can change this to your desired currency
    }).format(numberPrice);
};
