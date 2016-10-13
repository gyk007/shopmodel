<?php foreach ($export as $export) {
                              ?>
                              <div><?php echo $export['date']; ?>
                              <a title="Удалить из альбомов" onclick="if (!confirm('Действительно удалить?')) return false;" href="<?php echo $export['delete_link'] ?>">[x]</a></div>
                              <?php
                          }
?>
