
<link href="CSS/starrating.css" rel="stylesheet" type="text/css" />
<script type='text/javascript'>
function rateImg(rating)  {
		alert(rating);
		//remotos = new datosServidor;
		//nt = remotos.enviar('update.php?rating='+rating+'&imgId ='+imgId );
		//rating = (rating * 25) - 8;
		//document.getElementById('current-rating').style.width = rating+'px';
		//document.getElementById('valoration').value = imgId;
		//alert(imgId);
		//document.getElementById('ratingtext').innerHTML = 'Thank you for your rating!';
}
function MM_changeProp(theValue) {
	var pos=100+theValue*20;
	document.getElementById('Stars').style.backgroundPosition=pos+'px'; 
	//document.getElementById('Rate').value=theValue;
	
  }
function MM_getrate() {
	var pos1=100+document.getElementById('Rate').value*20;
	document.getElementById('Stars').style.backgroundPosition=pos1+'px'; 
	
  }
function MM_setrate(rate) {
document.getElementById('Rate').value=rate;	
  }


</script>

 <div class="starsAdd" id="Stars"> 
<img src="images/StarTransparent.png" alt="star1" width="20" height="20" class="star1"/>
<img src="images/StarTransparent.png" alt="star2" width="20" height="20" class="star2"/>
<img src="images/StarTransparent.png" alt="star3" width="20" height="20" class="star3"/>
<img src="images/StarTransparent.png" alt="star4" width="20" height="20" class="star4"/>
<img src="images/StarTransparent.png" alt="star5" width="20" height="20" class="star5"/>

</div>


<div class="vals" onmouseout="MM_getrate()" >
<div class="val" onmouseover="MM_changeProp('0')" onclick="MM_setrate(0)" title="0">
</div>
<div class="val" onmouseover="MM_changeProp('0.5')" onclick="MM_setrate(0.5)" title="0,5">
</div>
<div class="val" onmouseover="MM_changeProp('1')" onclick="MM_setrate(1)" title="1">
</div>
<div class="val" onmouseover="MM_changeProp('1.5')" onclick="MM_setrate(1.5)" title="1,5">
</div>
<div class="val" onmouseover="MM_changeProp('2')" onclick="MM_setrate(2)" title="2">
</div>
<div class="val" onmouseover="MM_changeProp('2.5')" onclick="MM_setrate(2.5)" title="2,5">
</div>
<div class="val" onmouseover="MM_changeProp('3')" onclick="MM_setrate(3)" title="3">
</div>
<div class="val" onmouseover="MM_changeProp('3.5')" onclick="MM_setrate(3.5)" title="3,5">
</div>
<div class="val" onmouseover="MM_changeProp('4')" onclick="MM_setrate(4)" title="4">
</div>
<div class="val" onmouseover="MM_changeProp('4.5')" onclick="MM_setrate(4.5)" title="4,5">
</div>
<div class="val" onmouseover="MM_changeProp('5')" onclick="MM_setrate(5)" title="5">
</div>
</div>


 <label for="Rate"></label>
   <input name="Rate" type="hidden" id="Rate" value=0 />
 