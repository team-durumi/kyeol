  document.createElement('header');
  document.createElement('footer');
  document.createElement('section');
  document.createElement('aside');
  document.createElement('nav');
  document.createElement('article');


//Tab
  function setLayer(tab, layer, obj){
	var tabObj = document.getElementById(tab).getElementsByTagName("A");
	var layerObj = document.getElementById(layer);
	var selectIdx;
	var checkIdx=0;
	
	for(var i=0; i< tabObj.length; i++){

		if(obj == tabObj[i]){
			selectIdx = i;
			tabObj[i].className = "on";
		}else{
			tabObj[i].className = "";
		}
	}
	
	for(var i=0; i< layerObj.childNodes.length; i++){
		if(layerObj.childNodes[i].tagName == "DIV"){
			if(checkIdx==selectIdx){
				layerObj.childNodes[i].style.display = "block";
			}else{
				layerObj.childNodes[i].style.display = "none";
			}
			checkIdx++;
		}
	}
}