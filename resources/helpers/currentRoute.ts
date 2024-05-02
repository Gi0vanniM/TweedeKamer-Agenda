/**
 * Function to get the parameter name of the current route.
 * By default, gets the first parameter
 * @param index determines how manyth parameter get's returned, by default on 1 to get the first parameter
 * @returns the parameter. E.g. 'dashboard' or 'agenda'.
 */
export function currentRoute(index: number = 1): String {
    return location.pathname.split('/')[index];
}