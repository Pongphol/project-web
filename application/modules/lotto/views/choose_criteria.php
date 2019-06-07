<div class="container mt-5 w-50">
    <div class="card border-secondary mb-12" >
        <div class="card-header"><h4>หวยรัฐบาล</h4></div>
        <div class="card-body">
            <?php if ($criteria) : ?>
            <table class="table table-hover table-bordered lotto_price_list">
                <thead>
                    <tr>
                        <th>เลข</th>
                        <th>ส่วนลด</th>
                        <th>จ่าย</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($criteria as $crit)
                        {
                            echo "
                                <tr>
                                    <td>{$crit->name}</td>
                                    <td class='number'>{$crit->discount}%</td>
                                    <td class='number'>{$crit->pay}</td>
                                </tr>
                            ";
                        }

                        echo '
                            <tr>
                                <td colspan="3" class="text-center">
                                    <a href="' . base_url('member/buy_lotto') . '" class="btn btn-success">เลือกราคานี้ <i class="far fa-arrow-alt-circle-up"></i></a>
                                </td>
                            </tr>';
                    else : 
                        echo '<strong class="d-block text-center">ไม่พบข้อมูล</strong>';
                    endif;
                    ?>
                
                </tbody>
            </table>
        </div>
    </div>
</div>