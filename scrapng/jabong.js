var fs = require('fs');
var casper = require('casper').create();


var couponObj = [];
var getListJson = '';
var url = casper.cli.get(0);
var url1 = 'http://54.243.150.171/getCouponCode.php?brand=';
var getList = 'http://54.243.150.171/getCashbackURLCpnVdo.php?brand='
var url2 = casper.cli.get(1);
var coupon_url = url1 + url2;
var getList_url = getList + url2;
var AddToCart = "#AddToCart";
var coupon_code='';
casper.start();
casper.on('remote.message', function (msg) {
    this.echo(msg);
});
casper.options.stepTimeout=120000;
//casper.options.timeout = 10000;

casper.options.waitTimeout = 30000;
casper
  .thenOpen(coupon_url)    //opens the url of coupons
  .then(function(){
    coupon_code = this.getPageContent().replace('<html><head></head><body>','').replace

('</body></html>','').replace(/'/g,"");
	//console.log(coupon_code);
  })

/*  .thenOpen(getList_url)    //opens the url of coupons
  .then(function(){
 getListJson = this.getPageContent().replace('<html><head></head><body>','').replace

('</body></html>','').replace(/<p>/g, '').replace(/<\/p>/g, '').replace(/<\/span>/g,'').replace

('</div></li></ol>','').replace(/&amp;/g, '&');

//console.log(getListJson);
  })
*/

  .thenOpen(url) 
casper.waitForSelector('#AddToCart')  

  .then(function(){
  
    		item= this.evaluate(function () 

			{
                var element = document.getElementById('jab-news');
              if (element != null) {
              	element.style.display = "none";
              }
              	var element = document.getElementsByClassName('jab-container')[0];
              if (element != null) {
              	element.style.display = "none";
              }
				for(var k = 0; k<10;k++)

					{
						var cName = document.getElementById

('listProductSizes').getElementsByTagName('li')[k].className;
console.log(cName.indexOf('sold-out')==-1);
              					if (cName.indexOf('unavailable')== -1 & 

cName.indexOf('sold-out')== -1) //first occurence of unavailable

							{


       								return k+1;
     								break;

     							}

					}


			});





		/*checks the availability of the product*/

		var itemXpath = '//*[@id="listProductSizes"]/li['+item+']'  //selects all the elements with the id mentioned
console.log(itemXpath);
		var x = require('casper').selectXPath;				//initialize x with 

selectXPath
            	var listProductSizes = '#listProductSizes';
		if (this.exists(listProductSizes)) 
	
			{//console.log('size selection '+itemXpath);

            			 this.thenClick(x(itemXpath), function() //if the element exists, clicks on the given itempath and then prints the message on the screen

					{
//this.capture('test1.png');
		
					});

			}

  })


  

  var x = require('casper').selectXPath;
  
  casper.thenClick(x('//*[@id="AddToCart"]'), function() //if the element exists, clicks on the given itempath and then prints the message on the screen

					{
	
//this.capture('test2.png');
		
					})
  //	casper.options.waitTimeout = 200000;
 // casper.waitForUrl('http://www.jabong.com/cart/')
  
  
					
 .thenOpen('http://www.jabong.com/cart/')
 .then(function()
	{
    		// scrape something else
    		
    	

    		var couponInformations = this.evaluate(couponPro,coupon_code);


    		

		//Iterates over provided array items and adds a step to the stack with current data attached to it:

		//here, on each element of the array couponInformations, performs the steps of functioneonse 
    		casper.eachThen(couponInformations, function (response) 

			{

    				var couponInformation = response.data;
        			
        			var couponElement = this.evaluate(couponAutoClickFeature, 

couponInformation, 0, 'couponCode', 'bt-coupon', 'resultMessage', 'domainElement');
//this.capture('liveTest.png');
var x = require('casper').selectXPath;
this.click(x('//*[@id="btn_apply_voucher"]'));
//console.log(JSON.stringify(couponElement));
        			this.waitFor(function check()
 
		{
//console.log(url+getListJson);			
 var checkCartPage = this.evaluate(checkCartPageType);
 if (checkCartPage == 'new'){
 	 var re = this.evaluate(couponClickCallbackNew, couponElement, url,getListJson);
 }
 else {
    var re = this.evaluate(couponClickCallbackOld, couponElement, url,getListJson);
}
    this.capture(couponElement.couponcode+'.png');
           					//console.log('---->'+JSON.stringify(re));
           					if (re != 'no' & re!='yes' & re!=null) 

							{

                						couponObj.push(re);
                
                						
							 }

			
            					if (re != 'no')

							{

            							re = 'found';

						            
							}

            					return re == 'found';

            					this.evaluate(function () 

							{               				
                						return re != 'no';

            						});

            
            
        					
					}, function then() 


						{
							var couponBlock = '#resultSuccMessage';


            						var x = require('casper').selectXPath;
            						if (this.exists(couponBlock)) 


								{


            								this.thenClick(x('//*[@id="resultSuccMessage"]/a'), function()

										 {

										 });

								}


            						this.waitFor(function check2() 

								{

//console.log('check2');
                							var re = this.evaluate

(close);
                							return re === 'yes';
                							this.evaluate(function () 

										{

                    									return re 

=== 'yes';
               									 });
	
            							}, function then() {
                							
            									    });

        					});





			});


    
 
	});



casper.run(function () {
//this.capture('runJabong.png');
var finalResult = this.evaluate(otherCodesString, couponObj);
//console.log('sorting');
function otherCodesString(couponObj) {
try{console.log('sgav'+document.getElementById("resultSuccMessage"));

	
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
{this.echo('['+JSON.stringify(couponObj).replace(/]/g,'').replace(/\[/g,'')+']');}  //to print the coupon allpied
else
{
	this.echo('['+JSON.stringify(finalResult).replace(/]/g,'').replace(/\[/g,'')+']'); } //to rint the coupon allpied
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


function couponPro(coupon_code) 


	{
    		var couponDetails = new couponApplied(0, 'init', 'INR 0', 'source', 'desc');

    		var myVar = '';
    		var finalClose = '';
    		var detailsArray = [];
    		try 

			{var couponInformation = JSON.parse(coupon_code);


      return couponInformation;



    			} catch (e) 

				{
        				//console.log(e.message);
   				 }

    		return b;


    		function couponApplied(i, couponCode, saving, source, description) 

			{
        			this.i = i;
        			this.couponCode = couponCode;
        			this.saving = saving;
        			this.source = source;
        			this.description = description;
    			}


    		function addButton(coupon_code) 

		{
var couponInformation = JSON.parse(coupon_code);


      return couponInformation;
    		}


	}

function couponAutoClickFeature(couponInformation, i, couponTextInputDiv, applyButtonDiv, 

checkIfValidCouponDiv, domainElement) 
	{
    		
    		try 
			{
        			var couponElement = couponInformation;
        			var couponCode = couponElement.couponcode;
        			var couponDes = couponElement.description;
        			var elem = document.getElementById(couponTextInputDiv);
        			elem.value = couponElement.couponcode;
        			
        			var source = couponElement.source;
        			//document.getElementsByClassName(applyButtonDiv)[0].click();


    			} catch (e) {
        				//console.log(e.message);
    					}


    		try 

			{
        			var myVar = ' ';
        			return couponElement;
        
    			} catch (e) {
        				//console.log('erroe..' + e.message);
    					}

	}





function checkCartPageType(){
	var element = document.getElementById("resultSuccMessage");
	if (element == null){
		return 'old';
	}
	else return 'new';
	
}

function couponClickCallbackOld(couponElement, url,getListJson) 


	{
		var payoption = "cart-new-pay-option";
		var resultMessage = 'resultMessage';
		var couponValue = 'couponValue';
		var couponna = 'coupon-na';
    		var check = document.getElementById(resultMessage);
    		console.log('11111111111111111111111'+ couponElement.couponcode+'--'+check);
		if (check.style.display=='none')

			{

				
        			return 'no';
			}
    		else if (check.innerHTML.indexOf('Rs. 0') > -1) 
				{

        				 return 'no';
    				} 

			else 


				{

        				
					if (check.innerHTML != null) 

						{

           						 
            											var coupon_money_value = document.getElementById(couponValue);
            											var coupon_na_text = document.getElementsByClassName('text-grey-bold coupon-pt35')[0];



if (typeof coupon_na_text === 'undefined') {
	coupon_na_text = document.getElementsByClassName('coupon-na')[0];
	
}
console.log(coupon_money_value+'------'+coupon_na_text);
            											if (coupon_na_text != null)

													

{
            												

	var saving = coupon_na_text.innerHTML.replace(/"/g,'');
            												

	var domain = extractRetailerNameFromDocDomain(document.domain);
           												

	var obj = updateSuccessfulCoupon(couponElement.couponcode, saving, couponElement.description,domain,url,0,getListJson);
            
	document.getElementById(resultMessage).style.display='none';
            
	document.getElementById(payoption).style.display='block';
            
	return obj;
            												
}
else if (coupon_money_value != null ) 

	{

		try

			{

var saving = Math.round(parseInt(coupon_money_value.innerHTML.replace('<td class="normal pbs pts">Voucher</td>', '').replace('<td class="strong pts">- Rs. ', '').replace('</td>', '')));
                											

				

													

			}catch(e){console.log('saving error '+e.message);}            //        
                											

		try 


													

			{



                											

				var domain = extractRetailerNameFromDocDomain(document.domain);
                    											

				var obj = updateSuccessfulCoupon(couponElement.couponcode, saving, couponElement.description,domain,url,1,getListJson);


			} catch (e) {
                    											

					//console.log(e.message);
                											

					}

                											

		try
 

													

			{

                    											

				document.getElementById(resultMessage).style.display='none';
                    											

				document.getElementById(payoption).style.display='block';
     
                   											

				
                	

													

			} catch (e) 

													

				{
                    											

				console.log('error ' + e.message);
                											

				}
                   


													

		
                	
                											

		return obj;

            												

	} 

													

else 

													

	{
                											

		return 'yes';
                	
                
            												

	}




            											

function extractRetailerNameFromDocDomain(docDomain)

 

													

{


          												

	if (docDomain==null){return null;
													

}

          		var domainSplitArr = docDomain.split(".");
          
          if (domainSplitArr == null || !(domainSplitArr.length > 0))
              												

return docDomain;


         var check = domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
          											if (check == 'co.in')

{
              												

	return domainSplitArr[domainSplitArr.length - 3] + "." + domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
          												

}



          						if (docDomain == 'www.google.co.in') return 'google';
          												

return domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
      




												}
            
							function updateSuccessfulCoupon(couponCode, saving, couponDescription,domain,url,Successful,getListJson) 

			

								{
url=url.split("?")[0];
/*var getList = JSON.parse(getListJson);	
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
}*/
                        
									var appliedCouponObj = [];
                        						appliedCouponObj.push(

							{
         							'couponCode': couponCode,
                            							'Saving': saving,
                            							'description':couponDescription,
                            						    'Successful':Successful,
                            							'domain':domain,
                            							'url':url,
                            							'BestCoupon':0
                        							})
                        

									return appliedCouponObj;
                 
		



								}




        

						} 


					else return 'no';



    
				}





	}


function couponClickCallbackNew(couponElement, url,getListJson) 


	{try{   console.log('sgav'+document.getElementById("resultSuccMessage"));
		var payoption = "cart-new-pay-option";
		var resultMessage = 'loadingContent';
		var couponValue = 'couponValue';
		var resultSucc = document.getElementById('resultSuccMessage');
		var resultErr = document.getElementById('resultErrMessage');
		var couponna = 'coupon-na';
    		var check = document.getElementById(resultMessage);
	}catch(e){console.log(e.message);}
    		//console.log('11111111111111111111111'+ couponElement.couponcode+'--'+resultSucc.style.display+'---'+resultErr.style.display);
	/*	if (check.style.display=='block' ||check ==null)

			{

				
        			return 'no';
			}*/
    		//else 
    		if (resultSucc.style.display=='none' && resultErr.style.display=='none') 
				{//console.log('not');

        				 return 'no';
    				} 

			else 


				{

        				
					if (resultSucc.style.display=='block') 

						{

           						 
            											var 

coupon_money_value = document.getElementById('couponDiscount').getElementsByTagName('p')[0].getElementsByTagName('span')[1];
            											

//console.log('coupon_money_value'+coupon_money_value);
            											

//var coupon_na_text = document.getElementsByClassName('text-grey-bold coupon-pt35')[0];


/*
if (typeof coupon_na_text === 'undefined') {
	coupon_na_text = document.getElementsByClassName('coupon-na')[0];
	
}
//console.log(coupon_money_value+'------'+coupon_na_text);*/
            											/*if 

(coupon_na_text != null)

													

{
            												

	var saving = coupon_na_text.innerHTML.replace(/"/g,'');
            												

	var domain = extractRetailerNameFromDocDomain(document.domain);
           												

	var obj = updateSuccessfulCoupon(couponElement.couponcode, saving, 

couponElement.description,domain,url,0,getListJson);
            
	document.getElementById(resultMessage).style.display='none';
            
	document.getElementById(payoption).style.display='block';
            
	return obj;
            												
}*/
//else
if (coupon_money_value != null ) 

	{

		try

			{
//console.log('coupon_money_value'+coupon_money_value.innerHTML);
var saving = Math.round(parseInt(coupon_money_value.innerHTML.replace('<td class="normal pbs pts">Voucher</td>', '').replace('- Rs.', '').replace('</td>', '')));
                											
//console.log('saving'+saving);
				

													

			}catch(e){console.log('saving error '+e.message);}            //        
                											

		try 


													

			{



                											

				var domain = extractRetailerNameFromDocDomain(document.domain);
                    											

				var obj = updateSuccessfulCoupon(couponElement.couponcode, saving, 

couponElement.description,domain,url,1,getListJson);


			} catch (e) {
                    											

					//console.log(e.message);
                											

					}

                											

		try
 

													

			{

                    											

//				document.getElementById(resultMessage).style.display='none';
                    											

//				document.getElementById(payoption).style.display='block';
     
                   											

				
                	

													

			} catch (e) 

													

				{
                    											

				console.log('error ' + e.message);
                											

				}
                   


													

		
                	
                											

		return obj;

            												

	} 
}
													
else if (resultErr.style.display =='block')

													

{
            												

	var saving = '';
	//coupon_na_text.innerHTML.replace(/"/g,'');
            												

	var domain = extractRetailerNameFromDocDomain(document.domain);
           												

	var obj = updateSuccessfulCoupon(couponElement.couponcode, saving, 

couponElement.description,domain,url,0,getListJson);
            
	//document.getElementById(resultMessage).style.display='none';
            
	//document.getElementById(payoption).style.display='block';
            
	return obj;
            												
}

else 

													

	{
                											

		return 'yes';
                	
                
            												

	}




            											

function extractRetailerNameFromDocDomain(docDomain)

 

													

{


          												

	if (docDomain==null){return null;
													

}

          		var domainSplitArr = docDomain.split(".");
          
          if (domainSplitArr == null || !(domainSplitArr.length > 0))
              												

return docDomain;


         var check = domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr

[domainSplitArr.length - 1];
          											if 

(check == 'co.in')

{
              												

	return domainSplitArr[domainSplitArr.length - 3] + "." + domainSplitArr

[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
          												

}



          						if (docDomain == 'www.google.co.in') return 

'google';
          												

return domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
      




												}
            
							function updateSuccessfulCoupon(couponCode, 

saving, couponDescription,domain,url,Successful,getListJson) 

			

								{
//console.log(getListJson);	
url=url.split("?")[0];
/*var getList = JSON.parse(getListJson);	
//console.log(getList);
var affiliate  =  getList.ActiveAffiliate;

//console.log('--------------------------->'+affiliate.toLowerCase());	
if (affiliate.toLowerCase()=='omg')
{
var url = getList.URLpart1+'&uid='+couponCode+'&r='+encodeURIComponent(url);}
else if (affiliate.toLowerCase()=="tyroo" || affiliate.toLowerCase()=='komli') {
var url = getList.URLpart1+'&lnkurl='+escape(escape(url+getList.URLpart2))+'&subid1='+couponCode

+'&subid2=couponVoodoo&subid3=live';
} 				
else if (affiliate.toLowerCase().indexOf('dgmpro')>-1) 
{
var url = getList.URLpart1+'?&k='+couponCode+'|couponVoodoo|live&t='+escape(escape(url
+getList.URLpart2));
}
*/
                        
									var appliedCouponObj = [];
                        						appliedCouponObj.push(

							{
         							'couponCode': couponCode,
                            							'Saving': saving,
                            							

'description':couponDescription,
                            						    'Successful':Successful,
                            							'domain':domain,
                            							'url':url,
                            							'BestCoupon':0
                        							})
                        

									return appliedCouponObj;
                 
		



								}




        

						} 


	



    
				}





	//}





function close() 


	{console.log('closeeeeeeeeee');
	var pgLoading = "loadingContent"; 
	var removeMask = "resultMessage";
	var payoption = "cart-new-pay-option";
	var giftclose = "gift-close"; 

    		try 

			{

				if (document.getElementById(pgLoading).style.display=='block')

					{

						return 'no';

					}

/* 				if (document.getElementById(removeMask).style.display=='block')

					{


 						document.getElementById

(removeMask).style.display='none';
 						document.getElementById

(payoption).style.display='block';
 						return 'no';

					}
  */     
        			//    clearInterval(finalClose);
/*
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
*/

			} catch (e) {console.log('close error '+e.message);}
    return 'yes';

	}

