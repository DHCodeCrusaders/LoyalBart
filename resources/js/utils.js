export function strLimit(str, limit) {
    return str.substr(0, limit) + (str.length > limit ? "..." : "");
}
