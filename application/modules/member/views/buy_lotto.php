<style>
.large_button{
    position:relative;
    height:100%;
}
.number_format{
    text-align: right;
}
.discount{
    color : red;
}
.total_net{
    color : green;
}
</style>
<script>
    $(document).ready(function(){
        
        inputFilter()
        validate_number_input()
        sum_twoTop_digit()
        sum_twoTod_digit()
        sum_twoBut_digit()
        sum_threeTop_digit()
        sum_threeTod_digit()
        sum_threeBut_digit()
        sum_total_2_digit()
        sum_total_3_digit()
        get_criteria_ajax()
        show_option_number()
    })
    function get_criteria_ajax()
    {
        $.ajax({
                type: "POST",
                url: "<?php echo base_url('member/get_criteria_ajax'); ?>",
                dataType: 'json',
                success: function(result){
                    $('.input_number2 ').on('keyup change focus',function(){
                        topTwo = result[4]['discount'] / 100
                        todTwo = result[3]['discount'] / 100
                        butTwo = result[5]['discount'] / 100
                        discount_2_digit(topTwo,todTwo,butTwo)
                    })
                    $('.input_number3 ').on('keyup change focus',function(){
                        topThree = result[0]['discount'] / 100
                        todThree = result[1]['discount'] / 100
                        butThree = result[2]['discount'] / 100
                        discount_3_digit(topThree,todThree,butThree)
                    })
                    $('.large_button').on('click',function(){
                        topTwo = result[4]['discount'] / 100
                        todTwo = result[3]['discount'] / 100
                        butTwo = result[5]['discount'] / 100
                        discount_2_digit(topTwo,todTwo,butTwo)
                        topThree = result[0]['discount'] / 100
                        todThree = result[1]['discount'] / 100
                        butThree = result[2]['discount'] / 100
                        discount_3_digit(topThree,todThree,butThree)
                    })

                }
        });
    }
    function inputFilter()
    {
        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                }
            });
        };
        $(".input_number").inputFilter(function(value) {
            return /^\d*$/.test(value) && (value === "" || parseInt(value) < 1000); 
        });
        $(".input_pay").inputFilter(function(value) {
            return /^\d*$/.test(value) && (value === "" || parseInt(value) < 10000); 
        });
        $(".number2").inputFilter(function(value) {
            return /^\d*$/.test(value) && (value === "" || parseInt(value) < 100); 
        });
        $(".number3").inputFilter(function(value) {
            return /^\d*$/.test(value) && (value === "" || parseInt(value) < 1000); 
        });
        $('#check_all_number').click(function(event) {   
            if(this.checked) 
            {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;                        
                });
            }
            else 
            {
                $(':checkbox').each(function() {
                    this.checked = false;                       
                });
            }
        });

    }
    function validate_number_input()
    {
        $('#number').keyup(function(){
            var number = ($('#number').val())
            if(number.toString().length == 3 || number.toString().length == 2 ){
                $('#number_top').attr('disabled',false)
                $('#number_tod').attr('disabled',false)
                $('#number_button').attr('disabled',false)
            }else{
                $('#number_top').attr('disabled',true)
                $('#number_tod').attr('disabled',true)
                $('#number_button').attr('disabled',true)
            }
        })
        $('#number').keyup(function(){
            if($('#number').val() != ""){
                $('#number').removeClass("is-invalid")
            }
        })
    }
    function input_number()
    {
        var number = ($('#number').val())
        if(number == ""){
            $('#number').addClass("is-invalid")
            $('#validate_number_input').addClass("invalid-feedback").text("กรุณากรอกเลขที่ต้องการลง")
        }else if(number.toString().length == 1){
            $('#number').addClass("is-invalid")
            $('#validate_number_input').addClass("invalid-feedback").text("กรุณากรอกเลขที่ถูกต้อง")
        }else{
            if(number.toString().length == 2){
                var number_top = $('#number_top').val()
                var number_tod = $('#number_tod').val()
                var number_button = $('#number_button').val()
                for(var i = 0 ; i < 10 ; i++ ){
                    if($('#number2_inp'+i).val() == ""){
                        if($('#number_tod').val() == ""){
                            $('#number2_inp'+i).val(number)
                            $('#number2_top_inp'+i).val(number_top)
                            $('#number2_tod_inp'+i).val("")
                            $('#number2_button_inp'+i).val(number_button)
                            $('#number').val("")
                            $('#number_top').val("")
                            $('#number_tod').val("")
                            $('#number_button').val("")
                            break;
                        }else{
                            var result_tod =  []
                            $.each($("input[name='list_num']:checked"), function(){            
                                result_tod.push($(this).val());
                            });
                            var temp = 0;
                            for(var j = i ; j < i+result_tod.length ; j++){
                                $('#number2_inp'+j).val(result_tod[temp++])
                                $('#number2_top_inp'+j).val(number_top)
                                $('#number2_tod_inp'+j).val(number_tod)
                                $('#number2_button_inp'+j).val(number_button)
                            }
                            $('#number').val("")
                            $('#number_top').val("")
                            $('#number_tod').val("")
                            $('#number_button').val("")
                            break;
                        }
                    }
                }
            }else if(number.toString().length == 3){
                var number_top = $('#number_top').val()
                var number_tod = $('#number_tod').val()
                var number_button = $('#number_button').val()
                for(var i = 0 ; i < 10 ; i++ ){
                    if($('#number3_inp'+i).val() == ""){
                        if($('#number_tod').val() == ""){
                            $('#number3_inp'+i).val(number)
                            $('#number3_top_inp'+i).val(number_top)
                            $('#number3_tod_inp'+i).val("")
                            $('#number3_button_inp'+i).val(number_button)
                            $('#number').val("")
                            $('#number_top').val("")
                            $('#number_tod').val("")
                            $('#number_button').val("")
                            break;
                        }else{
                            var result_tod =  []
                            $.each($("input[name='list_num']:checked"), function(){            
                                result_tod.push($(this).val());
                            });
                            var temp = 0;
                            for(var j = i ; j < i+result_tod.length ; j++){
                                $('#number3_inp'+j).val(result_tod[temp++])
                                $('#number3_top_inp'+j).val(number_top)
                                $('#number3_tod_inp'+j).val(number_tod)
                                $('#number3_button_inp'+j).val(number_button)
                            }
                            $('#number').val("")
                            $('#number_top').val("")
                            $('#number_tod').val("")
                            $('#number_button').val("")
                            break;
                        }
                        break;
                    }
                }
            }
        }
    }
    var permutate = (function() {
    var results = [];
    function doPermute(input, output, used, size, level) {
   
        if (size == level) {
            var word = output.join('');
            results.push(word);
            return;
        } 
        level++;
        for (var i = 0; i < input.length; i++) {
            if (used[i] === true) {
                continue;
            }
            used[i] = true;
            output.push(input[i]);
            doPermute(input, output, used, size, level);
            used[i] = false;
            output.pop();
            }
        }
        return {
            getPermutations: function(input, size) {
                var chars = input.split('');
                var output = [];
                var used = new Array(chars.length);
                results = [];
                doPermute(chars, output, used, size, 0);
                results = [...new Set(results)];
                return results;
            }
        }
    })();
    function sum_twoTop_digit(){
        $('.input_number2 ').on('keyup change focus',function(){
            var sum_twoTop = 0
            for(var i = 0 ; i < 10 ; i++){
            sum_twoTop += parseInt($('#number2_top_inp'+i).val()) || 0
            }
            $('#cash2_top_total').val(sum_twoTop)
            return sum_twoTop;
            return parseInt(sum_twoTop) || 0;
        })
        $('.large_button').on('click',function(){
            var sum_twoTop = 0
            for(var i = 0 ; i < 10 ; i++){
            sum_twoTop += parseInt($('#number2_top_inp'+i).val()) || 0
            }
            $('#cash2_top_total').val(sum_twoTop)
            return parseInt(sum_twoTop) || 0;
        })
    }
    function sum_twoTod_digit(){
        $('.input_number2 ').on('keyup change focus',function(){
            var sum_twoTod = 0
            for(var i = 0 ; i < 10 ; i++){
            sum_twoTod += parseInt($('#number2_tod_inp'+i).val()) || 0
            }
            $('#cash2_tod_total').val(sum_twoTod)
            return parseInt(sum_twoTod) || 0;
        })
        $('.large_button').on('click',function(){
            var sum_twoTod = 0
            for(var i = 0 ; i < 10 ; i++){
            sum_twoTod += parseInt($('#number2_tod_inp'+i).val()) || 0
            }
            $('#cash2_tod_total').val(sum_twoTod)
            return parseInt(sum_twoTod) || 0;
        })
    }
    function sum_twoBut_digit(){
        $('.input_number2 ').on('keyup change focus',function(){
            var sum_twoBut = 0
            for(var i = 0 ; i < 10 ; i++){
            sum_twoBut += parseInt($('#number2_button_inp'+i).val()) || 0
            }
            $('#cash2_but_total').val(sum_twoBut)
            return parseInt(sum_twoBut) || 0;
        })
        $('.large_button').on('click',function(){
            var sum_twoBut = 0
            for(var i = 0 ; i < 10 ; i++){
            sum_twoBut += parseInt($('#number2_button_inp'+i).val()) || 0
            }
            $('#cash2_but_total').val(sum_twoBut)
            return parseInt(sum_twoBut) || 0;
        })
    }
    function sum_threeTop_digit(){
        $('.input_number3 ').on('keyup change focus',function(){
            var sum_threeTop = 0
            for(var i = 0 ; i < 10 ; i++){
            sum_threeTop += parseInt($('#number3_top_inp'+i).val()) || 0
            }
            $('#cash3_top_total').val(sum_threeTop)
        })
        $('.large_button').on('click',function(){
            var sum_threeTop = 0
            for(var i = 0 ; i < 10 ; i++){
            sum_threeTop += parseInt($('#number3_top_inp'+i).val()) || 0
            }
            $('#cash3_top_total').val(sum_threeTop)
        })
    }
    function sum_threeTod_digit(){
        $('.input_number3 ').on('keyup change focus',function(){
            var sum_threeTod = 0
            for(var i = 0 ; i < 10 ; i++){
            sum_threeTod += parseInt($('#number3_tod_inp'+i).val()) || 0
            }
            $('#cash3_tod_total').val(sum_threeTod)
        })
        $('.large_button').on('click',function(){
            var sum_threeTod = 0
            for(var i = 0 ; i < 10 ; i++){
            sum_threeTod += parseInt($('#number3_tod_inp'+i).val()) || 0
            }
            $('#cash3_tod_total').val(sum_threeTod)
        })
    }
    function sum_threeBut_digit(){
        $('.input_number3 ').on('keyup change focus',function(){
            var sum_threeeBut = 0
            for(var i = 0 ; i < 10 ; i++){
            sum_threeeBut += parseInt($('#number3_button_inp'+i).val()) || 0
            }
            $('#cash3_but_total').val(sum_threeeBut)
        })
        $('.large_button').on('click',function(){
            var sum_threeeBut = 0
            for(var i = 0 ; i < 10 ; i++){
            sum_threeeBut += parseInt($('#number3_button_inp'+i).val()) || 0
            }
            $('#cash3_but_total').val(sum_threeeBut)
        })
    }
    function sum_total_2_digit(){
        $('.input_number2 ').on('keyup change focus',function(){
            var sum_two = 0
            sum_two = parseInt($('#cash2_top_total').val())+parseInt($('#cash2_tod_total').val())+parseInt($('#cash2_but_total').val()) || 0
            $('#cash2_total').val(sum_two)
        })
        $('.large_button').on('click',function(){
            var sum_two = 0
            sum_two = parseInt($('#cash2_top_total').val())+parseInt($('#cash2_tod_total').val())+parseInt($('#cash2_but_total').val()) || 0
            $('#cash2_total').val(sum_two)
        })
    }
    function sum_total_3_digit(){
        $('.input_number3 ').on('keyup change focus',function(){
            var sum_three = 0
            sum_three = parseInt($('#cash3_top_total').val())+parseInt($('#cash3_tod_total').val())+parseInt($('#cash3_but_total').val()) || 0
            $('#cash3_total').val(sum_three)
        })
        $('.large_button').on('click',function(){
            var sum_three = 0
            sum_three = parseInt($('#cash3_top_total').val())+parseInt($('#cash3_tod_total').val())+parseInt($('#cash3_but_total').val()) || 0
            $('#cash3_total').val(sum_three)
        })
    }
    function discount_2_digit(top,tod,but)
    {
        resutlTop = $('#cash2_top_total').val()*top
        resultTod = $('#cash2_tod_total').val()*tod
        resultBut = $('#cash2_but_total').val()*but
        sum_discount_2 = resutlTop + resultTod + resultBut
        $('#cash2_discount').val(sum_discount_2.toFixed(2))
        sum_total_2_net();
    }
    function discount_3_digit(top,tod,but)
    {
        resutlTop = $('#cash3_top_total').val()*top
        resultTod = $('#cash3_tod_total').val()*tod
        resultBut = $('#cash3_but_total').val()*but
        sum_discount_3 = resutlTop + resultTod + resultBut
        $('#cash3_discount').val(sum_discount_3.toFixed(2))
        sum_total_3_net()
    }
    function sum_total_2_net()
    {
        sum2net = $('#cash2_total').val() - $('#cash2_discount').val()
        $('#cash2_net').val(sum2net.toFixed(2))
        sum_total()
    }
    function sum_total_3_net()
    {
        sum3net = $('#cash3_total').val() - $('#cash3_discount').val()
        $('#cash3_net').val(sum3net.toFixed(2))
        sum_total()
    }
    function sum_total()
    {
        sum  = (parseInt($('#cash2_net').val()) || 0) + (parseInt($('#cash3_net').val()) || 0)
        $('#cash_total').val(sum.toFixed(2))
    }
    function comfirm_buy()
    {
        number2 = [];
        number3 = [];
        var temp = 0
        for(var i = 0 ; i < 10 ; i++){
            if($('#number2_inp'+i).val().toString().length == 3){
                $('#number2_inp'+i).addClass("is-invalid")
                temp++
            }
            if($('#number3_inp'+i).val().toString().length == 2){
                $('#number3_inp'+i).addClass("is-invalid")
                temp++
            }
        }
        if(temp == 0){
            for(var i = 0 ; i < 10 ; i++){
                number2.push({
                    number:$('#number2_inp'+i).val(),
                    numberTop:$('#number2_top_inp'+i).val(),
                    numberTod:$('#number2_tod_inp'+i).val(),
                    numberBut:$('#number2_button_inp'+i).val()
                })
                number3.push({
                    number:$('#number3_inp'+i).val(),
                    numberTop:$('#number3_top_inp'+i).val(),
                    numberTod:$('#number3_tod_inp'+i).val(),
                    numberBut:$('#number3_button_inp'+i).val()
                })
            }
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('member/buy_lotto_ajax'); ?>",
                dataType : "json",
                data:{
                    number2 : number2,
                    number3 : number3,
                    total_cash : $('#cash_total').val()
                },
                success: function(result){
                    if(result.status == "success"){
                        $.notify('ลงหวยสำเร็จ', {
                            className: 'success'
                        });
                        $("input.form-control:text").val("")
                    }else{
                        $.notify('ยอดเงินไม่เพียงพอ', {
                            className: 'error'
                        });
                    }
                }
            });
        }  
    }
    function show_option_number()
    {
        var table = "<div class='col'>"
            table += "<input type='checkbox'  id='check_all_number'>"
            table += "<label>เลือกทั้งหมด</label>"               
            table += "</div>"
            $('#number_tod_list').html(table)
        $('#number').keyup(function(){
            var table = "<div class='col'>"
            table += "<input type='checkbox'   id='check_all_number'>"
            table += "<label>เลือกทั้งหมด</label>"               
            table += "</div>"
            $('#number_tod_list').html(table)
            if($('#number').val().toString().length == 2){
                result_tod =  permutate.getPermutations($('#number').val(), 2);
                for(var i = 0 ; i < result_tod.length ; i++){
                    console.log(result_tod[i])
                    table += "<div class='col'>"
                    table += "<input type='checkbox'  value='"+result_tod[i]+"' name='list_num'>"
                    table += "<label>"+result_tod[i]+"</label>"
                    table += "</div>"
                }
                $('#number_tod_list').html(table)
            }else if($('#number').val().toString().length == 3){
                result_tod =  permutate.getPermutations($('#number').val(), 3);
                for(var i = 0 ; i < result_tod.length ; i++){
                    console.log(result_tod[i])
                    table += "<div class='col'>"
                    table += "<input type='checkbox'  value='"+result_tod[i]+"' name='list_num'>"
                    table += "<label>"+result_tod[i]+"</label>"
                    table += "</div>"
                }
                $('#number_tod_list').html(table)
            }
        })
    }
    

</script>   
<div class="container mt-5" >
    <div class="card border-secondary mb-12" >
        <div class="card-header"><h4>ลงหวย</h4></div>
            <div class="card-body">
                <div class="form-group">
                    <table class="table">
                        <tr>
                            <th><h3>เลข</h3></th>
                            <th><h3>บน</h3></th>
                            <th><h3>โต๊ด</h3></th>
                            <th><h3>ล่าง</h3></th>
                            <th rowspan="2"><button type="submit" class="btn btn-info btn-block large_button" id="input_table" onclick="input_number()">นำเข้าตาราง</button></th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control input_number" id="number" name="number">
                                <div id="validate_number_input"></div>
                            </td>
                            <td>
                                <input type="text" class="form-control input_pay" disabled id="number_top" name="number_top">
                            </td>
                            <td>
                                <input type="text" class="form-control input_pay" disabled id="number_tod" name="number_tod">
                            </td>
                            <td>
                                <input type="text" class="form-control input_pay" disabled id="number_button" name="number_button">
                            </td>
                        </tr>
                    </table>
                        <div class="row" id="number_tod_list">
                        </div>
                </div>
                <div class="form-group">
                    <table class="table">
                        <tr>
                            <td>
                                <table class="table table-bordered" id="">
                                    <thead>
                                        <tr class="table-primary" align="center">
                                            <th colspan="4">2 ตัว</th>
                                        </tr>
                                        <tr class="table-secondary" align="center">
                                            <th>เลข</th>
                                            <th>บน</th>
                                            <th>โต๊ด</th>
                                            <th>ล่าง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            for($i = 0 ; $i < 10 ; $i++)
                                            {
                                                echo "<tr>";
                                                echo "<td><input type='text' class='form-control input_number2 number2 number_format' id='number2_inp{$i}' name='number2_inp[{$i}]' ></td>";
                                                echo "<td><input type='text' class='form-control input_number2 number_format' id='number2_top_inp{$i}' name='number2_top_inp[{$i}]' ></td>";
                                                echo "<td><input type='text' class='form-control input_number2 number_format'  id='number2_tod_inp{$i}' name='number2_tod_inp[{$i}]' ></td>";
                                                echo "<td><input type='text' class='form-control input_number2 number_format' id='number2_button_inp{$i}' name='number2_button_inp[{$i}]' ></td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="table-primary" align="center">
                                            <th colspan="4">3 ตัว</th>
                                        </tr>
                                        <tr class="table-secondary" align="center">
                                            <th>เลข</th>
                                            <th>บน</th>
                                            <th>โต๊ด</th>
                                            <th>ล่าง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            for($i = 0 ; $i < 10 ; $i++)
                                            {
                                                echo "<tr>";
                                                echo "<td><input type='text' class='form-control input_number3  number3 number_format' id='number3_inp{$i}' name='number3_inp[{$i}]' ></td>";
                                                echo "<td><input type='text' class='form-control input_number3 number_format' id='number3_top_inp{$i}' name='number3_top_inp[{$i}]' ></td>";
                                                echo "<td><input type='text' class='form-control input_number3 number_format' id='number3_tod_inp{$i}' name='number3_tod_inp[{$i}]' ></td>";
                                                echo "<td><input type='text' class='form-control input_number3 number_format' id='number3_button_inp{$i}' name='number3_button_inp[{$i}]' ></td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash2_top_total">บนรวมเลข 2 ตัวจำนวน</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash2_top_total" disabled class="form-control number_format" name="cash2_top_total" >
                                    </div>
                                </div>
                            </td>                       
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash3_top_total">บนรวมเลข 3 ตัว</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash3_top_total" disabled class="form-control number_format" name="cash3_top_total" >
                                    </div>
                                </div>            
                            </td>                    
                        </tr>
                        <tr>
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash2_but_total">ล่างรวมเลข 2 ตัว</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash2_but_total" disabled class="form-control number_format" name="cash2_but_total" >
                                    </div>
                                </div>
                            </td>                       
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash3_but_total">ล่างรวมเลข 3 ตัว</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash3_but_total" disabled class="form-control number_format" name="cash3_but_total" >
                                    </div>
                                </div>            
                            </td>                    
                        </tr>
                        <tr>
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash2_tod_total">โต้ดรวมเลข 2 ตัว</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash2_tod_total" disabled class="form-control number_format" name="cash2_tod_total" >
                                    </div>
                                </div>                     
                            </td>
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash3_tod_total">โต้ดรวมเลข 3 ตัว</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash3_tod_total" disabled class="form-control number_format" name="cash3_tod_total" >
                                    </div>
                                </div>            
                            </td>      
                        </tr>
                        <tr>
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash2_total">รวมเลข 2 ตัวทั้งหมด</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash2_total" disabled class="form-control number_format" name="cash2_total" >
                                    </div>
                                    <div class="col">
                                        <label for="cash2_discount">ส่วนลดจำนวน</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash2_discount" disabled class="form-control number_format discount" name="cash2_discount" >
                                    </div>
                                </div>                            
                            </td>
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash3_total">รวมเลข 3 ตัวทั้งหมด</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash3_total" disabled class="form-control number_format " name="cash3_total" >
                                    </div>
                                    <div class="col">
                                        <label for="cash3_discount">ส่วนลดจำนวน</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash3_discount" disabled class="form-control number_format discount" name="cash3_discount" >
                                    </div>
                                </div>            
                            </td>      
                        </tr>        
                        <tr>
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash2_net">รวม</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash2_net" disabled class="form-control number_format total_net" name="cash2_net" >
                                    </div>
                                </div>
                            </td>                       
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash3_net">รวม</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash3_net" disabled class="form-control number_format total_net" name="cash3_net" >
                                    </div>
                                </div>            
                            </td>                    
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash_total">รวมทั้งหมด</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash_total" disabled class="form-control number_format total_net" name="cash_total" >
                                    </div>
                                </div>            
                            </td>
                        </tr>
                        <tr>
                        <td colspan='2' align="right"><button type="button" class="btn btn-success" onclick="comfirm_buy()">ยืนยัน</button></td>
                        </tr>      
                    </table>
                </div>
            </div>
    </div>
</div>