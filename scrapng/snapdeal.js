var fs = require('fs');
var casper = require('casper').create();
casper.on('remote.message', function (msg) {
    this.echo(msg);
});

var couponObj = [];
var url = casper.cli.get(0);
var url1 = 'http://54.243.150.171/getCouponCode.php?brand=';
var url2 = casper.cli.get(1);
var coupon_url = url1 + url2;
var getListJson = '';
var getList = 'http://54.243.150.171/getCashbackURLCpnVdo.php?brand=';
var getList_url = getList + url2;
//console.log(getList_url);
var couponObj = [];
var prevCouponElement = [];
var coupon_code;
var item =0;
casper.start();
casper.options.stepTimeout=120000;
casper.options.waitTimeout = 100000;
casper

  .thenOpen(coupon_url)    //opens the url of coupons


  .then(function(){
    coupon_code = this.getPageContent().replace('<html><head></head><body>','').replace('</body></html>','').replace(/'/g,"");
	
  })
.thenOpen(getList_url)    //opens the url of coupons
  .then(function(){
 getListJson = this.getPageContent().replace('<html><head></head><body>','').replace('</body></html>','').replace(/<p>/g, '').replace(/<\/p>/g, '').replace(/<\/span>/g,'').replace('</div></li></ol>','').replace(/&amp;/g, '&');
//console.log(getListJson);
  })

  .thenOpen(url)
.then(function () {
  	var checkMobile = this.evaluate(function () { 
  		var obj = document.getElementById('attribute-select-0'); 
  var divText = obj.innerHTML;
 // console.log(divText); 
  if (divText.indexOf('value="">--</option><option')>1){return 'yes';}else {return 'no';}
  	});
  	console.log('checkMobile   '+checkMobile);
		if (checkMobile=='yes'){
			this.thenEvaluate(function chooseRed(){

      // console.log($('#attribute-select-0'));
        var $select = $('#attribute-select-0');
        var _option = $select.find('option:last-child').val();
        $select.val(_option);
        $select.change();

});
this.waitForSelectorTextChange('.buyContainer', function(){
   // console.log('text changed on .buyContainer'); //just to be sure the button container changes.
});

this.thenClick('#BuyButton-1', function clickBuy(){
  //  console.log('clicked');

});
		}
	 	else {
  	var att_sel = 'attribute-select-0';
	item= this.evaluate(function () {
		var obj = document.getElementById('attribute-select-0'); 
		
		for(var k = 1; k<10;k++){
//var i=2*k+1;
//console.log(i);
		var cName = document.getElementById('attribute-select-0').getElementsByTagName('div')[0].getElementsByTagName('div')[k].className;
              		//console.log('cname'+cName);
     			if (cName.indexOf('Active')>-1){
       				return ((k/2)+1);
   
   				break;
     			}
		}

	});

if (item == null){item = 1;}
console.log(item);
	var itemXpath = '//*[@id="attribute-select-0"]/div/div['+item+']';
console.log(itemXpath);	
	var x = require('casper').selectXPath;
        if (this.exists(x(itemXpath))){
            
        	
            	this.thenClick(x(itemXpath), function() {
    		//	this.capture('snap.png');
    
    			 this.waitFor(function checkLoadingDiv() {
                		
                		var re = this.evaluate(checkLoading);
                
                		function checkLoading() {
				var buyContainerOverlay = "buyContainerOverlay";
    				try {if (document.getElementById(buyContainerOverlay).style.display=='block'){return 'no';}
       
    				} catch (e) {console.log('close error '+e.message);}
    				return 'yes';

				}
                	
                	return re === 'yes';
                	this.evaluate(function () {
                    		
                    		return re === 'yes';
                		});
            	}, function then() {
            		
            		});
		});
	}
	else {
	
	}
}
})

 .thenClick("#BuyButton-1").then(function () {
    // scrape something else
  // casper.options.waitTimeout = 30000;
   this.echo(this.getTitle());
    var x = require('casper').selectXPath;
            
            console.log('click');
          this.capture('sn1.png');
	    this.thenClick(x('//*[@id="checkout-cart"]/div/div[1]/span/a'), function() {
	
  			this.echo(this.getTitle());

    			this.echo("wrf");
			
                        
            });
            this.then(function(){
          //  this.capture('sn2.png');
            });
            
            this.thenClick('div.checkout-already_button.signinToCheckout', function(){
                
          //              this.capture("snaps.png");
                        
            });
            
           
            this.then(function(){
            this.waitUntilVisible('#ajaxSignin', function(){
               // this.capture("snapss.png");
                
                this.fill('form#ajaxSignin', {
                 'j_username' : 'testings123testings@gmail.com',
                 'j_password' : '1234rewq'
                }, false);
                
                 });
                 
            });
            
            
            this.thenClick('input#signin_submit.checkout-signin_buy_button');
            
            
            this.then(function(){
               
            this.waitWhileVisible('form#ajaxSignin', function then(){
            // this.capture('sn8.png'); 
             this.fill('form#customer-info-form', {
                 'name' : 'lavesh',
                 'mobile' : '9999999999'
                }, false);
            });    
            });
            this.then(function(){
             //   this.capture('sn9.png');
                this.click('button#customer-info-continue');
            });
            this.then(function(){
              //  this.capture('sn10.png');
                  
           this.waitUntilVisible('form#shipping-address-form', function(){
               this.fill('form#shipping-address-form', {
                 'address' : 'gurgaon',
                 'city' : 'gurgaon',
                 'state' : 'Haryana',
                 'zip' : '110022'
                }, false);
           });       
             });
              this.then(function(){
              //  this.capture('sn11.png');
              });
              
              this.thenClick('button#delivery-modes-continue');
              this.then(function(){
                  this.waitWhileVisible('.ajax-loader-outer', function(){
               // this.capture('sn12.png');
                  });
              });
                                                                             
})



.then(function () {
    // scrape something else
   //casper.options.waitTimeout = 30000;
  //console.log('-------------------------------------------');
			var x = require('casper').selectXPath;
			this.thenClick(x('//*[@id="promo-click-here"]'), function() {
    				
			});
			
			try{
    			var couponInformations = this.evaluate(couponPro, coupon_code);

    			}catch(e){console.log("error "+e.message);}
		
    casper.eachThen(couponInformations, function (response) {

    var couponInformation = response.data;
       
        var couponElement = this.evaluate(couponAutoClickFeature, couponInformation, 0,'couponCode', 'bt-coupon', 'resultMessage', 'domainElement');
   
   this.thenClick(x('//*[@id="order-summary"]/div[2]/div[1]/div[2]/div[2]/div'), function() {
   
});
        
       
        this.waitFor(function check() {
           
          // console.log('----->'+getListJson);
          //this.capture('type1.png');
            var re = this.evaluate(couponClickCallback, couponElement, url,getListJson);
          
           if (re != 'no' & re!='yes') {
                couponObj.push(re);
                
                
            }
            if (re != 'no'){
            	re = 'found';
            }
            return re == 'found';
            this.evaluate(function () {
                
                return re != 'no';
            });
            
            
        }, function then() {
      
          

        });


    });

    

 
});

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
}catch(e){console.log(e.message);} 
}   

if (JSON.stringify(finalResult)=='null' )
{this.echo('['+JSON.stringify(couponObj).replace(/]/g,'').replace(/\[/g,'')+']');}  
else
{
	this.echo('['+JSON.stringify(finalResult).replace(/]/g,'').replace(/\[/g,'')+']'); } this.exit();
});


function couponPro(coupon_code) {
    
   
       
      var couponInformation = JSON.parse(coupon_code);

      return couponInformation;
    
}

function couponAutoClickFeature(couponInformation, i, couponTextInputDiv, applyButtonDiv, 

checkIfValidCouponDiv,domainElement) {
    
    try {
       // console.log(JSON.stringify(couponInformation));
        var couponElement = couponInformation;
        var couponCode = couponElement.couponcode;
        var couponDes = couponElement.description;
        var elem = document.getElementById('promocode-input');
        elem.value = couponElement.couponcode;
       // console.log(couponCode+' elem '+elem);

        var source = couponElement.source;
              
    } catch (e) {
        console.log(e.message);
    }
    //                 return document.getElementById(couponTextInputDiv).value;      	
    try {
        var myVar = ' ';
        return couponElement;
        
    } catch (e) {
        console.log('erroe..' + e.message);
    }

}

function couponClickCallback(couponElement, url,getListJson) {
//console.log('ccccc'+getListJson);
    	

	var loading = 'loading-overlay';
	var dealdiv = 'deal-promo-value-div';
	var promoer = 'promo-code-error';
	try{
   
    		var check = document.getElementsByClassName(loading)[0].style.display;
   // console.log('check Loading '+check);
    	}catch(e){console.log(e.message);}
	if (check=='block'){
	
        return 'no';
	}
	else {
//console.log('check 2'+document.getElementById(dealdiv).style.display);
		if(document.getElementById(dealdiv).style.display=='none')
		{
            		try{      	
				checkIfValidCoupon = null;
                  		var saving = document.getElementById(promoer).innerHTML;
                  		//console.log(saving);
                  		if (saving.indexOf('null')>-1){return 'no';}
                  		var obj = updateSuccessfulCoupon(couponElement.couponcode,saving,couponElement.description,document.domain,url,0,getListJson);		

            		}catch(e){console.log(e.message);}
        	}
                  		
		else {
                                   		console.log('else'); 			
			try{
                  			var checkIfValidCoupon = document.getElementById('deal-promo-value');
                  		var saving = Math.round(parseInt(checkIfValidCoupon.innerHTML.replace('Rs. ', '').replace('-', '')));
                 		 var obj = updateSuccessfulCoupon(couponElement.couponcode,saving,couponElement.description,document.domain,url,1,getListJson);		

			}catch(e){console.log(e.message);}
                  		
		}
                  	
		return obj;

            
		function extractRetailerNameFromDocDomain(docDomain) {
          		if (docDomain==null){return null;}
          		var domainSplitArr = docDomain.split(".");
          
          		if (domainSplitArr == null || !(domainSplitArr.length > 0))
              			return docDomain;
          		var check = domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
          		if (check == 'co.in') {
              			return domainSplitArr[domainSplitArr.length - 3] + "." + domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
          		}
          		if (docDomain == 'www.google.co.in') return 'google';
          		return domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
      		}
            	
 function updateSuccessfulCoupon(couponCode, saving, couponDescription,domain,url,Successful,getListJson) 

								{
									//console.log


url=url.split("?")[0];
var getList = JSON.parse(getListJson);	
//console.log(getList);
var affiliate  =  getList.ActiveAffiliate;

//console.log('--------------------------->'+affiliate.toLowerCase());	
if (affiliate.toLowerCase()=='omg')
{
var url = getList.URLpart1+'?&uid1='+couponCode+'&uid2=couponVoodoo&uid3=live&redirect='+escape
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

function close() 


	{
	var pgLoading = "pgLoading cartPagePgLoading"; 
	var removeMask = "removeMask";
	var payoption = "cart-new-pay-option";
	var giftclose = "gift-close"; 

    		try 

			{

				if (document.getElementsByClassName(pgLoading)

[0].style.display=='block')

					{

						return 'no';

					}

 				if (document.getElementById(removeMask).style.display=='block')

					{


 						document.getElementById

(removeMask).style.display='none';
 						document.getElementById

(payoption).style.display='block';
 						return 'no';

					}
       
        			//    clearInterval(finalClose);

        			var a = document.getElementById(giftclose);
        			if (a != null) 

					{


        				}


        			$('#gift-close').click(function () 

					{

            					// prepare an action here, maybe say goodbye.
            					//
           			 		// if #tray-arrow is button or link <a href=...>
            					// you can allow or disallow going to the link:
            					// return true; // accept action
            					// return false; // disallow 

        				});


			} catch (e) {console.log('close error '+e.message);}
    return 'yes';

	}

