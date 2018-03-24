export default {
  arrayAddUnique (array, value) {
    if (array.indexOf(value) === -1) {
      array.push(value)
    }
    return array
  },
  arrayRemove (array, value) {
    const index = array.indexOf(value)
    if (index > -1) {
      array.splice(index, 1)
    }
    return array
  }
}
