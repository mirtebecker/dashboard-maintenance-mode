function toggle(switchElement) {
    if (switchElement.value == 'Deactivate' || switchElement.value == 'Activate')
    {
    		var x = document.getElementsByName('hide');
            for( var a = 0; a < x.length; a++  )
           		x[a].style.display = 'inline';
    }
    else
    {
    		var x = document.getElementsByName('hide');
            for( var a = 0; a < x.length; a++  )
           		x[a].style.display = 'none';
    }	 
}