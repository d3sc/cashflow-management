<div class="d-flex justify-content-between align-item-center">
    <h2>Daily Cashflow</h2>
</div>
<div class="table-responsive">
    <table id="daily" class="table table-striped table-hover table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th style="text-align: center;">Total Spend</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $index = 1;

            $sql = "SELECT *, SUM(spend) AS total_spend
                                FROM cashflow
                                GROUP BY DATE(time)
                                ORDER BY time;";

            $result = mysqli_query($conn, $sql);
            while ($data = mysqli_fetch_array($result)):
            ?>
                <tr>
                    <td><?php echo $index ?></td>
                    <td><?php echo date("Y-m-d", strtotime($data['time'])) ?></td>
                    <td style="text-align: center;"><?php echo "Rp." . number_format($data['total_spend'], 2, '.', ',') ?></td>
                    <td class="d-flex justify-content-center align-item-center gap-3">
                        <a href="cashflow/detail.php?date=<?php echo date("Y-m-d", strtotime($data['time'])) ?>">
                            <button class="btn btn-primary">Details</button>
                        </a>
                    </td>
                </tr>
            <?php
                $index++;
            endwhile;
            ?>
        </tbody>

    </table>
</div>