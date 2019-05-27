<div class="container mt-5 w-50">
    <div class="card border-secondary mb-12" >
        <div class="card-header"><h4>หวยรัฐบาล</h4></div>
        <div class="card-body">
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
                                    <td>{$crit->number}</td>
                                    <td class='number'>{$crit->discount}%</td>
                                    <td class='number'>{$crit->pay}</td>
                                </tr>
                            ";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>