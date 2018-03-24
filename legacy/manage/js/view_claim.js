function concat_checked(ids)
{
  var s = '';
  var first = true;

  for (var i = 0; i < ids.length; i++) {
    if (ids[i].checked) {
      if (first) {
        first = false;
      } else {
        s+=',';
      }

      s += ids[i].value;
    }
  }
  return s;
}