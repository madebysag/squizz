/**
 * 
 * @param {int} totalTime - in seconds
 * @returns {string} - in 00:00:00 format
 */
export function formatedTime (totalTime) {
    const hours = String(Math.floor(totalTime / 3600)).padStart(2, "00")
    const minutes = String(Math.floor((totalTime % 3600) / 60)).padStart(2, "00")
    const seconds = String(Math.floor(totalTime % 60)).padStart(2, "00")

    return `${hours}:${minutes}:${seconds}`;
}