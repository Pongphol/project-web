<div class="container-fluid mt-5" style="width: 60%;">
    <div class="mx-auto">
        <div class="card border-info mb-3">
            <div class="card-header">ข้อมูลผู้ใช้</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                    <table class="table table-hover table-bordered profile">
                        <tbody>
                            <?php
                                foreach($account_profile as $subject => $data)
                                {
                                    echo '<tr>';
                                    echo '<th scope="row" class="text-center">' . $subject . '</th>';
                                    echo '<td>' . $data . '</td>';
                                    echo '</tr>';
                                }
                                echo "<tr>
                                        <th></th>
                                        <td>
                                            <a href='" . base_url('edit') . "' class='btn btn-info'>แก้ไขข้อมูล</a>
                                        </td>
                                    </tr>";
                            ?>
                        </tbody>
                    </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>