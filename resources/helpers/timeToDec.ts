/**
 * Function to convert the time (e.g. 10:30) to a decimal number (e.g. 10.5)
 * By default, uses the current time
 * @param time
 * @returns the time in decimal number
 */
export function timeToDec(time: Date = new Date()): number {
    let decTime = 10;

    let hours = time.getHours();
    let minutes = time.getMinutes();
    let seconds = time.getSeconds();

    decTime = hours;
    decTime += (minutes / 60);
    decTime += (seconds / 60 / 60);

    return decTime;
}