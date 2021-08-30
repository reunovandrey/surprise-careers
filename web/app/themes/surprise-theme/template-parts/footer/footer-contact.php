<?php
$footer_contacts = get_field('footer_contact_info', 'option');

if (!isset($footer_contacts)) return;

foreach ($footer_contacts as $index => $contact) :
  $info = $contact['info'];
?>
  <div class="site-footer-info site-footer-info-<?php echo $index + 1; ?>">
    <p class="site-footer-contact"><?php echo esc_html( $info ); ?></p>
  </div>
<?php
endforeach;
