function sanjib() { alert('Jay Jagannath');
	/*document.write('its working');*/
	return {
        compile: function() {console.log("directive compile");}
    }
};
angular
    .module('AceApp')
    .directive('sanjib', sanjib)