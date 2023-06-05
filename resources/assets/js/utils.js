export const removeTrailingSlash = (str) =>
    str.endsWith('/') ? str.slice(0, -1) : str;
