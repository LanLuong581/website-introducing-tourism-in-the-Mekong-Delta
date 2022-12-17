<script>
    function jstophp(){
    
    
    var javavar=document.getElementById("text").value;  
    
    document.getElementById("rslt").innerHTML="<?php 
    $phpvar='"+javavar+"'; 
    echo $phpvar;?>";
    }
    
    function phptojs(){
    
    var javavar2 = "<?php 
    
    $phpvar2="I am php variable value";
    echo $phpvar2;
    
    ?>";
    alert(javavar2);
    }
    
    </script> 
    <body>
    <div id="rslt">
    </div>
    
    
    <input type="text" id="text" />
    <button onClick="jstophp()" >Convert js to php</button>
    <button onClick="phptojs()">Convert php to js</button>
    
    PHP variable will appear here:
    <div id="rslt2">
    </div>
    
    </body>