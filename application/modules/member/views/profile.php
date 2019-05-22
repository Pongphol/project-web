<div class="container-fluid mt-5" style="width: 60%;">
    <div class="mx-auto">
        <div class="card border-info mb-3">
            <div class="card-header">ข้อมูลผู้ใช้</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <?php $this->view('messages'); ?>
                        <table class="table table-hover table-bordered profile">
                            <tbody>
                                <?php
                                    foreach($account_profile as $subject => $data)
                                    {
                                        if ($subject != 'บัญชีธนาคาร')
                                        {
                                            echo '<tr>';
                                            echo '<th scope="row" class="text-center">' . $subject . '</th>';
                                            echo '<td>' . $data . '</td>';
                                            echo '</tr>';
                                        }
                                        else
                                        {
                                            echo '<tr scope="row" class="text-center"><th>บัญชีธนาคาร</th><td class="text-left">';

                                            foreach($account_profile[$subject] as $bank)
                                            {
                                                echo "
                                                    <div class='media'>
                                                        <div class='media-left'>
                                                            <a href='#'>
                                                                <img class='media-object' data-src='holder.js/64x64' style='width: 64px; height: 64px;' src='{$bank->picture}' alt='{$bank->name}'>
                                                            </a>
                                                        </div>
                                                        <div class='media-body ml-2'><p>{$bank->name} ({$bank->number})</p></div>
                                                    </div>
                                                    <hr>
                                                ";
                                            }

                                            echo '<a href="' . base_url('add_bank_account') . '" class="text-info">เพิ่มบัญชี</a> | 
                                                <a href="' . base_url('delete_bank_account') . '" class="text-info">ลบบัญชี</a></td></tr>';
                                        }
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