<!DOCTYPE html>
<html>

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<link href="../css/style.css" rel="stylesheet">


<meta name="viewport" content="width=device-width, initial-scale=1">

<script>
        var tableData=[];
        var filterData = [];
       $(document).ready(function(){
        console.log("ready");
        
        /*
        Create a new request object and when the document is loaded make the api call.
        check for status
        */
        const xhttp = new XMLHttpRequest();
        
        xhttp.onreadystatechange = function(){
            
             if(this.status==200 && this.readyState==4){
                /*response is in format of string, we want to navigate through to get KY records so 
                we need to convert it to array*/
                responseTxtArray = JSON.parse(this.responseText);                
                responseTxtArray.forEach(displayData);                
                showData(tableData);
             }
        }
        xhttp.open("GET","https://healthdata.gov/resource/7ctx-gtb7.json",true);
        xhttp.send();
        
       });
       
       function displayData(item,index){
        
            Object.keys(item).forEach(key=>{
                /**
                 * Filter data by state,get data for the state of Kentucky
                 */
                if(item[key]=="KY"){
                    //console.log(item) 
                    tableData.push(item);
                }                                           
            })
            /**
             * Date in the data is in ISO format eg yyyy-mm-ddThh:mm:ss
             * To convert it to yyyy-mm-dd, split it till the T 
             */
            for(i=0;i<tableData.length;i++){
                let collectionDt = tableData[i]["collection_date"];
                let formattedDt = collectionDt.split("T")[0];
                tableData[i]["collection_date"]= formattedDt;
            }             
       }
       /**
        * This function creates the data table.
        * tableData is the array containing data only for Kentucky
        */
       function showData(tableData){   
            keyArray=[];
            counter =0;
            for(i=0;i<tableData.length;i++){
               
                const rows = document.createElement("tr");    
                /**each item is a json obj, we need to convert to an array */
                keyArray = Object.entries(tableData[i])                
                arrayOfKey=Object.keys(tableData[i]);
                /**
                * We want header for the table, but if we loop through, it will get all 31 entries as headers,
                * so just count for 1 and add it as a header.
                */
                if(counter<1){
                    for(h=0;h<3;h++){
                        
                        th = document.createElement("th");                       
                        txtNode = document.createTextNode(arrayOfKey[h]);          
                        th.appendChild(txtNode)                                               
                        rows.appendChild(th);   
                        document.getElementById("data").appendChild(rows);                      
                    }
                    counter++;
                    
                }
                row1 = document.createElement("tr");
                Object.values(keyArray).forEach(key=>{
                    
                    if((key.indexOf("state")!=-1) || key.indexOf("collection_date")!=-1 || key.indexOf("staffed_adult_icu_beds_occupied_est")!=-1)
                    {          
                        tds = document.createElement("td");
                        txtNode = document.createTextNode(key[1]);
                        tds.appendChild(txtNode);        
                    }
                    row1.appendChild(tds);
                })              
                document.getElementById("data").appendChild(row1);
            }    
         
        } 
    </script>

</head>    
<body>
<div >
    <div class="header" >Health Data for KY</div>    
   
    <table id="data"></table>
    
    <div id="showReport" ></div>
<div>    

</body>
</html>