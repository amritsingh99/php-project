function doSomething(formData) {
    var obj = O(formData)
    var latitude = Number.parseFloat(obj.elements['latitude'].value)
    var panel_slope = Number.parseFloat(obj.elements['panel'].value)
    var rate = Number.parseFloat(obj.elements['rate'].value)
    var month = obj.elements['months'].value
    console.log(latitude);
    console.log(panel_slope);
    console.log(rate);
    console.log(month);

    if ((obj) => {
            array.forEach(element => {
                if (element == NaN || element == "") {
                    return false;
                }
            });
        }) { alert('Cannot accept empty form') }

}