<div class="d-flex justify-content-between align-item-center">
    <h2>Monthly Cashflow</h2>
</div>

<div class="table-responsive">

    <table id="monthly" class="table table-striped table-hover table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th style="text-align: center;">Total Spend</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $index = 1;

            $sql = "SELECT *, SUM(spend) AS total_spend
                FROM cashflow
                GROUP BY MONTH(time)
                ORDER BY time;";

            $result = mysqli_query($conn, $sql);
            while ($data = mysqli_fetch_array($result)):
            ?>
                <tr>
                    <td><?php echo $index ?></td>
                    <td><?php echo date("Y-m", strtotime($data['time'])) ?></td>
                    <td style="text-align: center;"><?php echo "Rp." . number_format($data['total_spend'], 2, '.', ',') ?></td>
                </tr>
            <?php
                $index++;
            endwhile;
            ?>
        </tbody>

    </table>
</div>