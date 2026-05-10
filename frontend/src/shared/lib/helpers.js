/**
 * Build a full image URL from domain + path
 */
export const imageUrl = (domain, path) => {
    if (!path) return '';

    if (/^https?:\/\//.test(path)) {
        return path;
    }

    const normalizedPath = `/${path.replace(/^\//, '')}`;

    if (!domain) {
        return normalizedPath;
    }

    return `${domain.replace(/\/$/, '')}${normalizedPath}`;
};

/**
 * Format a number as USD price
 */
export const formatPrice = (value) => {
    const num = Number(value);
    if (isNaN(num)) return '$0.00';
    return `$${num.toFixed(2)}`;
};

/**
 * Truncate a string to maxLength characters
 */
export const truncate = (str, maxLength = 100) => {
    if (!str) return '';
    return str.length > maxLength ? `${str.slice(0, maxLength)}…` : str;
};
