<section class="show dark">
    <div class="container-md">
        <div class="row">
            <table class="table table-dark table-hover text-center">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col" class="col-1">Primal link</th>
                    <th scope="col">Short link</th>
                    <th scope="col">Timestamp</th>
                    <th scope="col">Counter</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($links as $link): ?>
                <tr>
                    <td><?php echo $link['id']; ?></td>
                    <td class="text-start"><?php echo $link['primal_link']; ?></td>
                    <td><a href="/redirect/<?php echo $link['short_link']; ?>" style="text-decoration: none"><?php echo $link['short_link']; ?></a></td>
                    <td><?php echo $link['timestamp']; ?></td>
                    <td><?php echo $link['counter']; ?></td>
                    <td>
                        <a href="/delete/<?php echo $link['id'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>


