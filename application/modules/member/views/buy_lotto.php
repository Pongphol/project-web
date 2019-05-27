<style>
.large_button{
    position:relative;
    height:100%;
}
</style>
<script>
    $(document).ready(function(){
        $(".input_number").inputFilter(function(value) {
            return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500); });
        })
</script>   
<div class="container mt-5" >
    <div class="card border-secondary mb-12" >
        <div class="card-header"><h4>ลงหวย</h4></div>
            <div class="card-body">
                <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label><h3>เลข</h3></label>
                                <input type="number" class="form-control input_number" id="number" name="number">
                            </div>
                            <div class="col">
                                <label><h3>บน</h3></label>
                                <input type="number" class="form-control input_number" id="number_top" name="number_top">
                            </div>
                            <div class="col">
                                <label><h3>โต้ด</h3></label>
                                <input type="number" class="form-control input_number" id="number_tod" name="number_tod">
                            </div>
                            <div class="col">
                                <label><h3>ล่าง</h3></label>
                                <input type="number" class="form-control input_number" id="number_button" name="number_button">
                            </div>
                            <div class="col">
                                    <button type="submit" class="btn btn-info btn-block large_button" >นำเข้าตาราง</button>
                            </div>
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
                                            <th>โต้ด</th>
                                            <th>ล่าง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            for($i = 0 ; $i < 10 ; $i++)
                                            {
                                                echo "<tr>";
                                                echo "<td><input type='number' class='form-control input_number'  name='number2_inp' ></td>";
                                                echo "<td><input type='number' class='form-control input_number'  name='number2_top_inp' ></td>";
                                                echo "<td><input type='number' class='form-control input_number'  name='number2_tod_inp' ></td>";
                                                echo "<td><input type='number' class='form-control input_number'  name='number2_button_inp' ></td>";
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
                                            <th>โต้ด</th>
                                            <th>ล่าง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            for($i = 0 ; $i < 10 ; $i++)
                                            {
                                                echo "<tr>";
                                                echo "<td><input type='number' class='form-control input_number'  name='number3_inp' ></td>";
                                                echo "<td><input type='number' class='form-control input_number'  name='number3_top_inp' ></td>";
                                                echo "<td><input type='number' class='form-control input_number'  name='number3_tod_inp' ></td>";
                                                echo "<td><input type='number' class='form-control input_number'  name='number3_button_inp' ></td>";
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
                                        <input type="text" id="cash2_top_total"  class="form-control" name="cash2_top_total" >
                                    </div>
                                </div>
                            </td>                       
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash3_top_total">บนรวมเลข 3 ตัว</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash3_top_total"  class="form-control" name="cash3_top_total" >
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
                                        <input type="text" id="cash2_but_total"  class="form-control" name="cash2_but_total" >
                                    </div>
                                </div>
                            </td>                       
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash3_but_total">ล่างรวมเลข 3 ตัว</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash3_but_total"  class="form-control" name="cash3_but_total" >
                                    </div>
                                </div>            
                            </td>                    
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash3_tod_total">โต้ดรวมเลข 3 ตัว</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash3_tod_total"  class="form-control" name="cash3_tod_total" >
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
                                        <input type="text" id="cash2_total"  class="form-control" name="cash2_total" >
                                    </div>
                                    <div class="col">
                                        <label for="cash2_discount">ส่วนลดจำนวน</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash2_discount"  class="form-control" name="cash2_discount" >
                                    </div>
                                </div>                            
                            </td>
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash3_total">รวมเลข 3 ตัวทั้งหมด</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash3_total"  class="form-control" name="cash3_total" >
                                    </div>
                                    <div class="col">
                                        <label for="cash3_discount">ส่วนลดจำนวน</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash3_discount"  class="form-control" name="cash3_discount" >
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
                                        <input type="text" id="cash2_net"  class="form-control" name="cash2_net" >
                                    </div>
                                </div>
                            </td>                       
                            <td>
                                <div class="row" class="form-group">
                                    <div class="col">
                                        <label for="cash3_net">รวม</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="cash3_net"  class="form-control" name="cash3_net" >
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
                                        <input type="text" id="fname"  class="form-control" name="firstname" >
                                    </div>
                                </div>            
                            </td>
                        </tr>      
                    </table>
                </div>
            </div>
    </div>
</div>