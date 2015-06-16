$(document).ready(function(){
	
		
	var _CaptionTransitions = [];
    _CaptionTransitions["T"] = { $Duration: 800, y: 0.6, $Easing: { $Top: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
	_CaptionTransitions["MCLIP|B"] = { $Duration: 600, $Clip: 8, $Move: true, $Easing: $JssorEasing$.$EaseOutExpo };

	var options = {
		$AutoPlay: true, 
		$DragOrientation: 3,  
		$CaptionSliderOptions: {  
		$Class: $JssorCaptionSlider$, 
		$CaptionTransitions: _CaptionTransitions,   
		$PlayInMode: 1,     
		$PlayOutMode: 3,   
		},
		$ArrowNavigatorOptions:
			{
			    $Class: $JssorArrowNavigator$,
			    $ChanceToShow: 2
			}
	}
	
	var jssor_sliderTop = new $JssorSlider$('slidertop_container', options);	
	var jssor_sliderBottom = new $JssorSlider$('sliderbottom_container', options);
});


