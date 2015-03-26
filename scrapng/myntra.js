//create casper object
var fs = require('fs');
var casper = require('casper').create({
    pageSettings: {
        loadImages:  true, // do not load images
        loadPlugins: false         // do not load NPAPI plugins (Flash, Silverlight, ...)
    }
});

casper.on('remote.message', function (msg) {
    this.echo(msg);
});
var couponObj = [];
var coupon_code;
var serverCount = 1;
var url = casper.cli.get(0);
url = url.replace(/ampersand/g,"&");
var url1 = 'http://54.243.150.171/getCouponCode.php?brand=';
var url2 = casper.cli.get(1);
serverCount = casper.cli.get(2);
var coupon_url = url1 + url2;
var getListJson = '';
var getList = 'http://54.243.150.171/getCashbackURLCpnVdo.php?brand=';
var getList_url = getList + url2;
console.log(getList_url);
casper.start();
casper.on('remote.message', function (msg) {
    this.echo(msg);
});
casper.options.stepTimeout=240000;
casper.options.waitTimeout = 10000;

casper
  .thenOpen(coupon_url)    //opens the url of coupons
  .then(function(){
    coupon_code = this.getPageContent().replace('<html><head></head><body>','').replace('</body></html>','').replace(/'/g,"");
console.log(coupon_code);
  })
.thenOpen(getList_url)    //opens the url of coupons
  .then(function(){

 getListJson = this.getPageContent().replace('<html><head></head><body>','').replace('</body></html>','').replace(/<p>/g, '').replace(/<\/p>/g, '').replace(/<\/span>/g,'').replace('</div></li></ol>','').replace(/&amp;/g, '&');
console.log(getListJson);
  })

casper.thenOpen('http://www.myntra.com/');


casper.then(function() {
console.log(1);
// Click on LOGIN / SIGN UP
    this.click('div.mk-f-right a.btn-login');
});
/*casper.wait(1000, function(){
//this.capture('Login1.png');
    // Click Login 
console.log(2);
this.click('span.signup-content span.blue');
});*/

casper.wait(100, function(){
//this.capture('Login2.png');	
console.log('---------------------------');
console.log(serverCount);
    //fill form
    this.fill('form.login-content', {
        'email' : 'tst'+serverCount+'@gmail.com',
        'password' : '1234rewq'
    }, true);              

});


//
casper.wait(5000, function(){
this.then(function() {
		var checkCart= this.evaluate(function () 
		  {try{
			var check = document.getElementsByClassName('bag-cont')[0].innerHTML;
                        console.log(check);
			if (check.indexOf("<strong>0</strong>")==-1){
				return 'yes';
			}
			else {return 'no';}
		  }catch(e){console.log(e.message);}
			});
			console.log('checkCart '+checkCart);
		if (checkCart == 'yes') {
console.log('--------------------->');
	   this.thenOpen('http://www.myntra.com/cart.php', function() {
console.log('<<--------------------->');
this.wait(2000, function(){
//this.capture('cartRemoval.png');
	   
  var x = require('casper').selectXPath;
 var removeXpath = '/html/body/div[2]/div/div[1]/div[2]/div[1]/div[1]/div[2]/div[1]/span[3]';
   if (this.exists(x(removeXpath))) { removeXpath = removeXpath ;} 
else if (this.exists(x('/html/body/div[2]/div/div[1]/div[2]/div[1]/div[2]/div[2]/div[1]/span[3]'))) {removeXpath = '/html/body/div[2]/div/div[1]/div[2]/div[1]/div[2]/div[2]/div[1]/span[3]';}
 else {removeXpath = '//span[@class="delete-item"]';}
 this.click(x(removeXpath), function() 

{
 
   	console.log('==========================================>');
});

 this.click(('span.delete-item'), function() 
{
 
});


});
    //this.capture('cartRemoval2.png');  
  
		
		});
		
		}	

console.log(4);
   
});
});

//open home page
casper.wait(5000, function(){
 //this.capture('screen.png');
this.thenOpen('http://www.myntra.com/home.php/', function() {
console.log(4);
   // this.capture('screen.png');

});
});

casper.thenOpen(url)

 .then(function(){
  
    		this.echo(this.getTitle());
    		this.echo("wrf");

		//not clear//
		/*function to select the product*/
		item= this.evaluate(function () 

			{

				for(var k = 0; k<10;k++)

					{
				var cName = document.getElementsByClassName('options')[0].getElementsByTagName('button')[k].className;
              					console.log(cName);
     						if (cName.indexOf('unavailable')==-1) //first occurence of unavailable

							{


       								return k+1;
     								break;

     							}

					}


			});


		/*checks the availability of the product*/

		var itemXpath = ' //*[@id="mk-filler"]/div/div[2]/div[1]/div[1]/div[2]/button['+item+']' ; //selects all the elements with the id mentioned
		console.log(itemXpath);
		var x = require('casper').selectXPath;				//initialize x with selectXPath
            
		if (this.exists('#mk-filler')) 

		 	{ 
 if (this.exists(x(itemXpath))) { itemXpath = itemXpath ;} 
 else if (this.exists(x('//*[@id="mk-filler"]/div/div[3]/div[1]/div[1]/div[2]/button['+item+']'))) 
 {
 	console.log('dfdsf');
 	itemXpath = '//*[@id="mk-filler"]/div/div[3]/div[1]/div[1]/div[2]/button['+item+']'; 
 }
  else if (this.exists(x('//*[@id="mk-filler"]/div/div[2]/div[2]/div[1]/div[2]/button['+item+']'))) 
 {
 	console.log('dfdsf');
 	itemXpath = '//*[@id="mk-filler"]/div/div[2]/div[2]/div[1]/div[2]/button['+item+']'; 

} else if (this.exists(x('//*[@id="mk-filler"]/div/div[3]/div[2]/div[1]/div[2]/button['+item+']'))) 
 {
 	
 	itemXpath = '//*[@id="mk-filler"]/div/div[3]/div[2]/div[1]/div[2]/button['+item+']';
 } else  {
 	
 	itemXpath = '//*[@id="mk-filler"]/div/div[4]/div[1]/div[1]/div[2]/button['+item+']';
 }            			console.log('exist');
           			 this.thenClick(x(itemXpath), function() //if the element exists, clicks on the given itempath and then prints the message on the screen

					{
	

			    			console.log("Woop!");

		
					});

			}

  })
 
casper.then(function() {
	console.log(5);
	this.click('div.add-button-group button.mk-add-to-cart');
	
		if (this.exists('#lb-addedtocombo')) {
			console.log('=================>');
			this.wait(5000, function(){
				var x = require('casper').selectXPath ;
			this.click(x('//*[@id="lb-addedtocombo"]/div/div[2]/div[2]/a[1]'));
				//this.capture('clickcombo.png');
			
		});
		
		}

});

casper.open('http://www.myntra.com/cart.php');
casper.then(function() {
	console.log(7);
	//this.capture('scr2.png');
	
});
casper.wait(5000, function(){

	console.log(8);
		var x = require('casper').selectXPath ;
			//this.capture('1.png');
//	this.click(x('/html/body/div[2]/div/div[1]/div[2]/div[3]/div[1]/a'));
this.click('a.apply-coupon');   
      		//this.capture('2.png');
})
		casper.wait(1000, function(){

			//this.capture('b4apply1.png');
//console.log('------------->'+getListJson);  
 	//	var d = this.evaluate(skippingToCouponStep);
 		var couponInformations = this.evaluate(couponPro, coupon_code);
     		casper.eachThen(couponInformations, function (response) {

    			var couponInformation = response.data;
        
        		var couponElement = this.evaluate(couponAutoClickFeature, couponInformation);
    
   			var x = require('casper').selectXPath ;
   	    		var couponDiv = 'coupon_block' ;
			var cartLoad = 'add-to-cart-loader' ; 
			//this.capture('b4apply.png');
				this.click(x('//*[@id="lb-add-coupon"]/div/div[3]/button[1]'));
				
				this.wait(3000,function(){//this.capture('a.png');
})
				//this.capture('a4apply.png');
        		this.waitFor(function check() {
           			 var re = this.evaluate(couponClickCallback, couponElement, couponDiv, cartLoad, url,getListJson);
           console.log('re.....'+JSON.stringify(re));
           			if (re != 'no' & re!='yes' & re!=null) {
                		couponObj.push(re);
                
                
            							}
            			if (re != 'no'){
            	// this.capture('check0.png');
           			var x = require('casper').selectXPath;
   				
        
       		 		re = 'found';
            		  				}
            		return re == 'found';
            		this.evaluate(function () {
                
                	return re != 'no';
            				});
            
            
        			}, function then() {
       	 	this.thenClick(x('/html/body/div[2]/div/div[1]/div[2]/div[3]/div[1]/span[8]'), 
function() {
    
	// this.capture('check11.png');
            	this.waitForSelector('#lb-add-coupon');
            
          			this.waitFor(function checkLoadingDiv() {
//this.capture('check1.png');
                							var re = this.evaluate(checkLoading);
    
console.log('re1'+re);
//		this.capture('check2.png');						
                							function checkLoading() {
	
    									try {
       
          									var check = document.getElementById('lb-add-coupon');
  
  console.log('ccccc'+check);
										if (check == null || typeof check === 'undefined'){
	
        									return 'no';
										}
    									} catch (e) {console.log(e.message);}
    									return 'yes';

									}
                							return re === 'yes';
                							this.evaluate(function () {
                    
                    								return re === 'yes';
                							});
            								}, function then() {
            									 this.thenClick(x('//*[@id="lb-add-coupon"]/div/div[2]/div/div[1]/a'), 
function() {//this.capture('f.png');
});
 this.thenClick(x('//*[@id="lb-add-coupon"]/div/div[2]/div/div[1]/form/input'), 
function() {//this.capture('f1.png');
});
   
       //	this.capture('check3.png');						     
            this.waitFor(function checkLoadingDiv() {
                
                							var re = this.evaluate(checkLoading);

//this.capture('f2.png');
console.log('re222'+re);

                							function checkLoading() {
document.getElementsByClassName('btn primary-btn btn-apply')[0].disabled=false;									
    									try {return 'yes';
       
          									var check = document.getElementById('lb-add-coupon').style.display;
  
  
										if (check == 'none'){
	
        									return 'no';
										}
    									} catch (e) {}
    									return 'yes';

									}

               
                							return re === 'yes';
                							this.evaluate(function () {
                    
                    								return re === 'yes';
                							});
            								}, function then() {
                
            								});
          
            								});
          
	
        	});				});



    					});
    					
    					item= this.evaluate(function () 

			{
 
   try{
	document.getElementById('lightbox-shim').style.display='none';
	document.getElementById('lb-add-coupon').style.display='none';
}catch(e){console.log(e.message);}
	return 'done';
   })
   console.log(item);
   var x = require('casper').selectXPath;
 
 var removeXpath = '/html/body/div[2]/div/div[1]/div[2]/div[1]/div[1]/div[2]/div[1]/span[3]'; 

if (this.exists(x(removeXpath))) { removeXpath = removeXpath ;} 	 	
	   else if (this.exists(x('/html/body/div[2]/div/div[1]/div[2]/div[1]/div[2]/div[2]/div[1]/span[3]'))) {removeXpath = '/html/body/div[2]/div/div[1]/div[2]/div[1]/div[2]/div[2]/div[1]/span[3]';}	 	
	   else {removeXpath = '//span[@class="delete-item"]';}	 	
	   this.thenClick(x(removeXpath), function() {


   	console.log('clickeed');
});
 this.wait(5000,function(){//this.capture('run1.png');
})

				});//funcltion response closes
  
casper.run(function () {

//this.capture('run.png')
var finalResult = this.evaluate(otherCodesString, couponObj);
function otherCodesString(couponObj) {
try{
try{
	document.getElementById('lightbox-shim').style.display='none';
	document.getElementById('lb-add-coupon').style.display='none';
}catch(e){console.log(e.message);}
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
	var x = require('casper').selectXPath;
  this.thenClick(x('/html/body/div[2]/div/div[1]/div[2]/div[1]/div[1]/div[2]/div[1]/span[3]'), function() {
    });
    this.wait(5000,function(){//this.capture('run.png');
})

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
        var elem = document.getElementsByClassName('ui-autocomplete-input')[0];
        elem.value = couponElement.couponcode;
        
        
console.log(elem.value);
        var source = couponElement.source;
              var notif = document.getElementsByClassName('wrapper')[0];
if (notif != null){
	notif.style.display='none';
	
}

    } catch (e) {
console.log('recent'+e.message);        
    }
          	
    try {
        var myVar = ' ';
        return couponElement;
        
    } catch (e) {
        
    }

}


function couponClickCallback(couponElement, couponDiv,cartLoad, url,getListJson) {
try{
console.info(JSON.stringify(couponElement));
    var check = document.getElementsByClassName('row coupon-info text-coupon')[0];
   var appliedCpn = document.getElementById('lb-add-coupon').style.display;
    
    var clgreen = 'green';
    var pstcpnsuc = 'postCouponSuccess';
    var pstcpnerr = 'postCouponError';
    var tbcpn = 'tab-coupon';
console.log('check'+check+' '+appliedCpn);
}catch(e){console.log(e.message);}
	if (typeof check === 'undefined' & appliedCpn == 'block')
	{
	       	return 'no';
	}
	else {
        
	//	var checkIfValidCoupon = document.getElementsByClassName(clgreen)[0];
        
        console.log(typeof check != 'undefined');
        	if (typeof check != 'undefined'){
        		if (check.innerHTML.indexOf('invalid')){
 
//	console.log('yyyyyyyyy');
            		try{      	
 
        		var saving = check.innerHTML;
                  		console.log('ssssss'+saving);
                  	var obj = updateSuccessfulCoupon(couponElement.couponcode, saving,couponElement.description,document.domain,url,0,getListJson);			
                  		//document.getElementById(tbcpn).style.display='block';
            		}catch(e){console.log(e.message);}
        	}
        	}   		
		else {console.log('eeeeeeeeeeeeee');
                  		
                  			try{
                  				var checkIfValidCoupon = document.getElementsByClassName('greenrupees')[0];
                  	
                  			var saving = checkIfValidCoupon.innerHTML.replace('Rs. ', '').replace('-', '').replace(' ', '').replace(',', '');
                  		//	if (saving == '0' || saving == 0){ return 'no'; }
                  			var obj = updateSuccessfulCoupon(couponElement.couponcode, saving,couponElement.description,document.domain,url,1,getListJson);			 		
                  		
                  			}catch(e){console.log(e.message);}
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