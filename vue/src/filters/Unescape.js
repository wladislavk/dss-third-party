export default function (value) {
  const newValue = value.replace(/&amp;/g, '&')
  return newValue
}
