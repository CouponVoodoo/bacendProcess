var fs = require('fs');
var casper = require('casper').create();

casper.on('remote.message', function (msg) {
    this.echo(msg);
});

var couponObj = [];
var url = casper.cli.get(0);
var url2 = casper.cli.get(1);
var getListJson = '';
var getList = 'http://54.243.150.171/getCashbackURLCpnVdo.php?brand=';
var getList_url = getList + url2;
var offer = '';
casper.start();
casper.on('remote.message', function (msg) {
    this.echo(msg);
});
casper.options.waitTimeout = 10000;
//var couponInformations = '';
casper
  .thenOpen(url) 
  .then(function(){
  			
    		this.echo(this.getTitle());
    		this.echo("wrf");
	this.capture('fktcheck.jpg');
offer= this.evaluate(function () 

			{
				
			
  var offerCheck = document.getElementsByClassName('text-offers')[0];
  console.log('offerCheck'+offerCheck);
  if(typeof offerCheck === 'undefined'){
  console.log('--------');
  return '';
  }else
  {
  	offer = offerCheck.getElementsByTagName('div')[0].getElementsByTagName('div')[0].innerHTML;  	
  return offer.replace('<span class="green-text">',"").replace('</span>','').replace(/\n/g,"").trim();
//str_replace('','</span>',str_replace('',,offer));
  }
  
			});
  console.log(offer);
		//not clear//
		/*function to select the product*/
		item= this.evaluate(function () 

			{
				for(var k = 0; k<10;k++)

					{
						var cName = document.getElementsByClassName('sectionImage section-boxes boxes')[0].getElementsByTagName('a')[k].className;
              					console.log(cName);
     						if (cName.indexOf('soldout')==-1) //first occurence of unavailable

							{


       								return k+1;
     								break;

     							}

					}


			});




console.log('----->'+item);
		/*checks the availability of the product*/

		var itemXpath = '//*[@id="multiselection"]/div/div[2]/div[2]/a['+item+']/div/div'  //selects all the elements with the id mentioned
		console.log(itemXpath);
		var x = require('casper').selectXPath;//initialize x with selectXPath
            
		if (this.exists(x(itemXpath))) 
	
	//		{

            			console.log('exist');
           			 this.thenClick(x(itemXpath), function() //if the element exists, clicks on the given itempath and then prints the message on the screen

					{
	

			    			console.log("Woop!");

		//this.capture('fkt1.png');
		
		 this.waitFor(function checkLoadingDiv() {
                		
                		var re = this.evaluate(checkLoading);
                
                		function checkLoading() {
				var buyContainerOverlay = "blocker";
    				try {if (document.getElementById(buyContainerOverlay).style.display=='block')

{return 'no';}
       
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
           
		//	}

  })
  var x = require('casper').selectXPath;
  casper.thenClick(x('//*[@id="mprod-buy-btn"]/a'), function() //if the element exists, clicks on the given itempath and then prints the message on the screen

					{
this.waitFor(function checkLoadingDiv() {
                		
                		var re = this.evaluate(checkLoading);
                
                		function checkLoading() {
				var buyContainerOverlay = "loader cart-loader";
    				try {if (document.getElementsByClassName(buyContainerOverlay)[0].style.display=='block'){return 'no';}
       
    				} catch (e) {console.log('close error '+e.message);}
    				return 'yes';

				}
                	
                	return re === 'yes';
                	this.evaluate(function () {
                    		
                    		return re === 'yes';
                		});
            	}, function then() {
            		
            		});	

			    			console.log("Woop!");

		//this.capture('fkt2.png');
					})
 
 .then(function()
	{
    		// scrape something else
    		this.echo(this.getTitle());

    		this.echo("click dd to cart");

    		casper.options.waitTimeout = 10000;

 

		//Iterates over provided array items and adds a step to the stack with current data attached to it:

		//here, on each element of the array couponInformations, performs the steps of function response 

  //  				var couponInformation = response.data;
        			//console.log('couponInformation  ' + couponInformation);

//        			var couponElement = this.evaluate(couponAutoClickFeature, couponInformation, 0, 'couponCode', 'bt-coupon', 'resultMessage', 'domainElement');


        			console.log('couponElement');




        			this.waitFor(function check()
 
					{
            					console.log('yoyoyoy');
           console.log('-----'+offer);
            					var re = this.evaluate(couponClickCallback, 'couponElement', url,offer);

           					console.log('reeeeeeeeeec '+JSON.stringify(re));

           					if (re != 'no' & re!='yes') 

							{

                						couponObj.push(re);
                
                						console.log('result ' + JSON.stringify(couponObj));
           


							 }

			
            					if (re != 'no')

							{

            							re = 'found';

						            
							}

            					return re == 'found';

            					this.evaluate(function () 

							{


                						console.log('inside 3');

                						return re != 'no';

            						});

            
            
        					
					}, function then() 
{

						});

 
	});



casper.run(function () {

var finalResult =couponObj;
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
   if (parseInt(finalResult[0][0].Saving) >0){
   
   finalResult[0][0].BestCoupon = 1;}
//this.echo(finalResult);
this.echo('['+JSON.stringify(finalResult).replace(/]/g,'').replace(/\[/g,'')+']');
this.exit();
});



function couponPro(cartURL, brand, buttonDiv, couponTextInputDiv, applyButtonDiv, checkIfValidCouponDiv, 

domainElement) 


	{
    		console.log('testing...dd');
    		var couponDetails = new couponApplied(0, 'init', 'INR 0', 'source', 'desc');

    		var myVar = '';
    		var finalClose = '';
    		var detailsArray = [];
    		try 

			{
        			var b = addButton(buttonDiv, brand, couponDetails, couponTextInputDiv, applyButtonDiv, checkIfValidCouponDiv, domainElement, 'no');

    			} catch (e) 

				{
        				console.log(e.message);
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


    		function addButton(buttonDiv, brand, couponDetails, couponTextInputDiv, applyButtonDiv, 

checkIfValidCouponDiv, domainElement, isReload) 

		{

        console.log('testing...ll');
        console.log('testing...yyyyyy');
        return couponInformation;
    		}


	}









function couponAutoClickFeature(couponInformation, i, couponTextInputDiv, applyButtonDiv, 

checkIfValidCouponDiv, domainElement) 
	{
    		console.log('testing...couponAutoClickFeature');
    		try 
			{
        			console.log(JSON.stringify(couponInformation));
        			var couponElement = couponInformation;
        			var couponCode = couponElement.couponcode;
        			var couponDes = couponElement.description;
        			console.log(couponTextInputDiv);
        			console.log(document.getElementById(couponTextInputDiv).innerHTML);
        			var elem = document.getElementById(couponTextInputDiv);
        			elem.value = couponElement.couponcode;
        			console.log(couponCode+' elem '+elem);

        			var source = couponElement.source;
        			document.getElementsByClassName(applyButtonDiv)[0].click();


    			} catch (e) {
        				console.log(e.message);
    					}


    		//                 return document.getElementById(couponTextInputDiv).value;      	
    		try 

			{
        			var myVar = ' ';
        			return couponElement;
        
    			} catch (e) {
        				console.log('erroe..' + e.message);
    					}

	}









function couponClickCallback(couponElement,url,offer) 


	{
    		console.log(JSON.stringify(couponElement));
    		//---------------------------------------------------
    		//                             clearInterval(myVar);
    		//       return 'yes';
    		var check = document.getElementsByClassName('fk-ui-dialog newvd cart-dialog')[0];
		if (check.style.display=='none')

			{
				console.log('none');
        			return 'no';
			}
    		else 
var checkSaving = document.getElementsByClassName('promo-savings-total ')[0];
			
					if (checkSaving != null) 

						{

           						 //                               try { 

            													

var saving = checkSaving.innerHTML.replace(/"/g,'/\'').replace('Rs. ','');
            													

var cpnDesc = document.getElementsByClassName('promo-info fk-inline-block fk-font-small')[0].innerHTML.trim();
            													

var domain = extractRetailerNameFromDocDomain(document.domain);
           													

var obj = updateSuccessfulCoupon('Flipkart Offer', saving,cpnDesc ,domain,url,1);
            
         													

//   couponObj.push(obj);
            													

console.log('inside '+JSON.stringify(obj));
            
               													

return obj;
            												
}

   else 
		{


if (offer != ''){
var saving = 1;
var cpnDesc = offer;
var succ = 1;
var cpnCode = 'Flipkart Offer';
} 
else {
var saving = '';
var cpnDesc = 'No Offer Available on this product';
var succ = 0;
var cpnCode = 'No Offer Available on this product';
}                												

			var domain = extractRetailerNameFromDocDomain(document.domain);
                    												

			var obj = updateSuccessfulCoupon(cpnCode,saving , cpnDesc,domain,url,succ);

    														

			//                couponObj.push(obj);
 														

			console.log('inside '+JSON.stringify(obj));


                												

		} 
          
	console.log('hmmm '+JSON.stringify(obj));
                	
                												

	return obj;

            													

 




            											function 

extractRetailerNameFromDocDomain(docDomain)

 

													{


          													

if (docDomain==null){return null;
													}

          											var 

domainSplitArr = docDomain.split(".");
          
          											if 

(domainSplitArr == null || !(domainSplitArr.length > 0))
              												return 

docDomain;


          											var check = 

domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
          											if (check == 

'co.in')

 

													{
              													

return domainSplitArr[domainSplitArr.length - 3] + "." + domainSplitArr[domainSplitArr.length - 2] + "." + 

domainSplitArr[domainSplitArr.length - 1];
          												}



          											if (docDomain 

== 'www.google.co.in') return 'google';
          												return 

domainSplitArr[domainSplitArr.length - 2] + "." + domainSplitArr[domainSplitArr.length - 1];
      




												}
            
							function updateSuccessfulCoupon(couponCode, saving, 

couponDescription,domain,url,Successful) 

								{
console.log('dcd');


url=url.split("?")[0];




//console.log('--------------------------->'+affiliate.toLowerCase());	
var url = url+'?affid=teamthesho';

                        
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


			



    
				











