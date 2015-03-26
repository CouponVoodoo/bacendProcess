//create casper object

var casper = require('casper').create();
var url = 'http://www.shopclues.com/crad-shining-black-sunglasses.html';
var url = casper.cli.get(0);
var url1 = 'http://54.243.150.171/getCouponCode.php?brand=';
var url2 = casper.cli.get(1);
var url2 = 'shopclues';
var coupon_code;

var couponObj = [];
var coupon_code;
var coupon_url = url1 + url2;
var getListJson = '';
var getList = 'http://54.243.150.171/getCashbackURLCpnVdo.php?brand=';
var getList_url = getList + url2;


//var casper = require('casper');
//casper.create();

//set browser user agent
//casper.userAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X)');

//Open URL
casper.start();
casper.options.stepTimeout=240000;
casper.options.waitTimeout = 10000;
//set browser user agent
//casper.userAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X)');

//Open URL
casper.start();
casper.thenOpen(coupon_url);    //opens the url of coupons
casper.then(function(){
    coupon_code = this.getPageContent().replace('<html><head></head><body>','').replace

('</body></html>','').replace(/'/g,"");
	  })

 .thenOpen(getList_url)    //opens the url of coupons
  .then(function(){
 getListJson = this.getPageContent().replace('<html><head></head><body>','').replace('</body></html>','').replace(/<p>/g, '').replace(/<\/p>/g, '').replace(/<\/span>/g,'').replace('</div></li></ol>','').replace(/&amp;/g, '&');
//console.log(getListJson);
  })




casper.thenOpen(url);

casper.then(function() {
	//this.echo(this.getTitle());
	this.evaluate(function() {
	document.getElementById('popup_exp_reg').style.display='none';
	});
	//this.capture('shop1.png');
	this.click('span.button-submit-action input');
});

casper.then(function() {
this.evaluate(function() {
document.getElementsByClassName('product-notification')[0].style.display='block';
});
});
casper.wait(2000, function(){

//this.capture('shop2.png');
});
casper.then(function() {

this.click('div.box_functions a.box_functions_button.margin_right_five');

});

casper.wait(2000, function(){

//this.capture('shop3.png');

});


casper.then(function() {

    //fill form
    this.fill('form[name=step_one_login_form]', {
        'user_login' : 'lavesh@theshoppingpro.com',
        'password' : '1234rewq'
    }, false);              

    //submit form
    this.thenClick('div#haveaccount div.box_functions input.box_functions_button', function(){

        // Here I'm in my myAccount Page        
       // this.capture('shop4.png');    

        // Do something ...
    });

});
casper.wait(2000, function(){

//this.capture('shop5.png');
this.thenClick('span.button-submit');
this.thenOpen('https://secure.shopclues.com/index.php?dispatch=checkout.checkout&edit_step=step_three');

})

.then(function(){ 
//console.log('------------->'+getListJson);  
 	//	var d = this.evaluate(skippingToCouponStep);
 		var couponInformations = this.evaluate(couponPro, coupon_code);
     		casper.eachThen(couponInformations, function (response) {

    			var couponInformation = response.data;
        
        		var couponElement = this.evaluate(couponAutoClickFeature,couponInformation);
        			//console.log('couponElement'+couponElement.couponcode);
   // this.capture('b4TabCoupon.png');
   			var x = require('casper').selectXPath;
   			this.thenClick(x('//*[@id="step_three_body"]/div/div[1]/div[2]/div/form/div/div[3]/a'), function() {
   				//console.log('click');
   // this.capture('tabCoupon.png');
											});
        
        		var couponDiv = 'coupon_block';
			var cartLoad = 'add-to-cart-loader'; 
        		this.waitFor(function check() {
        			//console.log(couponInformation.couponcode);
           			 var re = this.evaluate(couponClickCallback, couponInformation 

,couponDiv, cartLoad, url,getListJson);
           //console.log(JSON.stringify(re));
           			if (re != 'no' & re!='yes' & re!=null) {
                		couponObj.push(re);
                             // console.log(JSON.stringify(re));
            							}
            			if (re != 'no'){
            	
           			var x = require('casper').selectXPath;
   				this.thenClick(x('//*[@id="step_three_body"]/div/div[1]/div[2]/div/form/div/div[5]/a'), function() {
   // this.capture('coupon_block.png');
										});
            	
        
       		 		re = 'found';
            		  				}
            		return re == 'found';
            		this.evaluate(function () {
                
                	return re != 'no';
            				});
            
            
        			}, function then() {
       	 
            
          			this.waitFor(function checkLoadingDiv() {
                
                var re = this.evaluate(checkLoading);
            console.log('re'+re);
            //console.log('checkLoading '+re);
                							function checkLoading() {
									
    									try {
       
          									var check = document.getElementById('ajax_loading_box').style.display;
  
  // return 'check'+ check;
										if (check == 'block'){
	
        									return 'no';
										}
    									} catch (e) {return e.message;}
    									return 'yes';

									}

               
                							return re === 'yes';
                							this.evaluate(function () {
                    
                    								return re === 'yes';
                							});
            								}, function then() {
                
            								});
          

        					});



    					});


				});//funcltion response closes
  





casper.run(function () {

var finalResult = this.evaluate(otherCodesString, couponObj);
function otherCodesString(couponObj) {
try{

	
	couponObj.sort(function (a, b) {
    a = +a[0].Saving, b = +b[0].Saving; // cast Number
    // special cases
    if (a !== a) { // if `a` NaN
        if (b !== b) return 0; // both NaN; no action
        return 1; // move it to end
    }
    if (b !== b) // if `b` NaN
        return -1; // move it to end
    // classic descending sort
    return b - a;
});
                     
   if (parseInt(couponObj[0][0].Saving) >0){
   
   couponObj[0][0].BestCoupon = 1;}
                 return couponObj;
}catch(e){} 
} 
//console.log('re '+JSON.stringify(finalResult));
if (JSON.stringify(finalResult)=='null' )
{this.echo('['+JSON.stringify(couponObj).replace(/]/g,'').replace(/\[/g,'')+']');}  //to print the coupon allpied
else
{
	this.echo('['+JSON.stringify(finalResult).replace(/]/g,'').replace(/\[/g,'')+']'); } //to print the coupon allpied
this.exit();
});




function errorObject(ErrorCode,Description) {
                        var appliedCouponObj = [];
                        appliedCouponObj.push({
                            'ErrorCode': ErrorCode,
                            'Description': Description
                            
                        })
                        return appliedCouponObj;
                    }








function couponPro(coupon_code) {
 

    
  
      var couponInformation = JSON.parse(coupon_code);

return couponInformation;
   
}


function couponAutoClickFeature(couponInformation) {
   
    
    try {
    	
        
        var couponElement = couponInformation;
        var couponCode = couponElement.couponcode;
        var couponDes = couponElement.description;
        
        var elem = document.getElementById('coupon_field');
        elem.value = couponElement.couponcode;
        
       // var source = couponElement.source;
              
    } catch (e) {
        
    }
          	
    try {
        var myVar = ' ';
        return couponElement;
        
    } catch (e) {
        
    }

}


function couponClickCallback(couponElement, couponDiv,cartLoad, url,getListJson) {
   try{// console.info(JSON.stringify(couponElement));
    var check1 = document.getElementsByClassName('notification-header-w')[0];
    var check2 = document.getElementsByClassName('form_twocolumnwithbutton_fieldabout')

[0].innerHTML;
   
   
   }catch(e){return e.message ;}
	if (typeof check1 == 'undefined' & check2.indexOf(couponElement.couponcode) == -1 )
	{
	
        	return 'no';
	}
	else {
       // return document.getElementById(pstcpnsuc).innerHTML;
	//	var checkIfValidCoupon = document.getElementsByClassName(clgreen)[0];
        
        	if (check2.indexOf(couponElement.couponcode) > -1){
 
            		try{      	
 
        		var saving = document.getElementsByClassName('box_paymentcalculations_field')[1].innerHTML.replace('Rs.', '').replace('\n', '');
                  		
                  	var obj = updateSuccessfulCoupon(couponElement.couponcode, saving,couponElement.description,document.domain,url,1,getListJson);			
                  		//document.getElementById(tbcpn).style.display='block';
            		}catch(e){return 'vgv'+e.message ;}
        	}
                  		
		else {
                  		
                  			try{//return 'ch'+checkIfValidCoupon;
                  	
                  			var saving = check1.innerHTML;
                  			var obj = updateSuccessfulCoupon(couponElement.couponcode, saving,couponElement.description,document.domain,url,0,getListJson);			 		
                  	
                  			}catch(e){return e.message;}
                  	}
                  		
                  		

              return obj;



                  	
            function extractRetailerNameFromDocDomain(docDomain) {
          	if (docDomain==null){return null;}
          	var domainSplitArr = docDomain.split(".");
          
          	if (domainSplitArr == null || !(domainSplitArr.length > 0))
             	 return docDomain;
          	var check = domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr

[domainSplitArr.length - 1];
          	if (check == 'co.in') {
              	return domainSplitArr[domainSplitArr.length - 3] + "." + domainSplitArr

[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
          	}
          	if (docDomain == 'www.google.co.in') return 'google';
          	return domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr

[domainSplitArr.length - 1];
      	    }





           function updateSuccessfulCoupon(couponCode, saving, 

couponDescription,domain,url,Successful,getListJson) 

			

								{
url=url.split("?")[0];
var getList = JSON.parse(getListJson);	
//console.log(getList);
var affiliate  =  getList.ActiveAffiliate;

//console.log('--------------------------->'+affiliate.toLowerCase());	
if (affiliate.toLowerCase()=='omg')
{
var url = getList.URLpart1+'?&uid='+couponCode+'&redirect='+escape

(escape(url+getList.URLpart2));}
else if (affiliate.toLowerCase()=="tyroo" || affiliate.toLowerCase()=='komli') {
var url = getList.URLpart1+'&lnkurl='+escape(escape(url+getList.URLpart2))+'&subid1='+couponCode+'&subid2=couponVoodoo&subid3=live';
} 				
else if (affiliate.toLowerCase().indexOf('dgmpro')>-1) 
{
var url = getList.URLpart1+'?&k='+couponCode+'|couponVoodoo|live&t='+escape(escape(url

+getList.URLpart2));
}
                        
									var appliedCouponObj = [];
                        						appliedCouponObj.push(

							{
         							'couponCode': couponCode,
                            							'Saving': saving,
                            							'description': 

couponDescription,
                            						    'Successful':Successful,
                            							'domain':domain,
                            							'url':url,
                            							'BestCoupon':0
                        							})
                        

									return appliedCouponObj;
                 
		



								}



       
    }
}







function close() {
 
var pgload = 'pgLoading cartPagePgLoading';
var remMask= 'removeMask';
var cartPay= 'cart-new-pay-option'

var gClose='gift-close';

    try {
        
 
 if (document.getElementsByClassName(pgload)[0].style.display=='block')

{return 'no';}
 if (document.getElementById(remMask).style.display=='block'){
 	document.getElementById(remMask).style.display='none';
 	document.getElementById(cartPay).style.display='block';
 	return 'no';}
       
        
        var a = document.getElementById(gClose);
        
        if (a != null) {

            //document.getElementById(gClose).onClick();
            //		 $("#gift-close")[0].click();

        }
        $('#gift-close').click(function () {

            // prepare an action here, maybe say goodbye.
            //
            // if #tray-arrow is button or link <a href=...>
            // you can allow or disallow going to the link:
            // return true; // accept action
            // return false; // disallow 
        });


    } catch (e) {}
    return 'yes';

}




function skippingToCouponStep() {
var loginDiv = 'checkout-step-login';
var shipDiv = 'checkout-step-shipping';
var codeDiv = 'coupon_code';

try{
	
	document.getElementById(loginDiv).style.display ='none';
	document.getElementById(shipDiv).style.display ='block';
	document.getElementById(codeDiv).style.display ='block';
}catch(e){}
return 'done';
}

function test(test){
var formDiv ='product_addtocart_form';

var url = document.getElementById(formDiv).action;	

	return url;
}