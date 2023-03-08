<!DOCTYPE html>
<html>

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<link href="https://unpkg.com/tabulator-tables/dist/css/tabulator_modern.min.css" rel="stylesheet">
<script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> 

<meta name="viewport" content="width=device-width, initial-scale=1">

<script>
        var tableData=[];
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
            showData(tableData);
       }
       function showData(tableData){
            
            for(i=0;i<tableData.length;i++){
               let collectionDt = tableData[i]["collection_date"];
               let formattedDt = collectionDt.split("T")[0];
               
               tableData[i]["collection_date"]= formattedDt;
            }
            var displayTable = new Tabulator('#data-table',{
              height:"400px",

              data:tableData,
              layout:"fitDataStretch",
              columns:[
                    {title:"State",field:"state",width:250},
                    {title:"Collection Date",field:"collection_date",width:250},
                    {title:"Staffed Adult ICU Beds",field:"staffed_adult_icu_beds_occupied_est",width:150}
              ]
              
            });
               
        } 
    </script>

</head>    
<body>
<div class="container">
    <div id="showReport" class="d-flex p-3 bg-primary text-white">Health Data for KY</div>    
    <div id="data-table" ></div>
    <div id="showReport" ></div>  
</div>
<?php
    //echo "On first page calling";
?>
</body>
</html>