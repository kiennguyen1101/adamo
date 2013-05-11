<?php


  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>

<table width="100%" border="0" cellpadding="3" cellspacing="2">
  <tr class="c4">
    <td colspan="3">Auction Preview</td>
  </tr>
  <tr class="c5">
    <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="150" height="1"></td>
    <td colspan="2" width="100%"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td colspan="3" style="padding-left: 50px; padding-right: 50px;"><?php echo $auction_details_page; ?></td>
  </tr>
  <?php
    if (isset($auction_fees_box)) {
      $output['display'] = '<tr class="c4"> ' .
        '	<td colspan="3">' . GMSG_AUCTION_FEES . '</td> ' .
        '</tr> ' .
        '<tr class="c5"> ' .
        '	<td><img src="themes/' . $this->setts['default_theme'] . '/img/pixel.gif" width="150" height="1"></td> ' .
        '	<td colspan="2"><img src="themes/' . $this->setts['default_theme'] . '/img/pixel.gif" width="1" height="1"></td> ' .
        '</tr> ';

      foreach ($auction_fees_box['charged_fee_tier'] as $key => $value) {
        $output['display'] .= '<tr class="c1"> ' .
          '	<td align="right">' . GMSG_SETUP_FEE . '</td> ' .
          '	<td nowrap colspan="2">' . $value ['value'] . $value['display'] . '</td> ' .
          '</tr> ';
      }

      foreach ($auction_fees_box['charged_fee_no_tier'] as $key => $value) {
        $output['display'] .= '<tr class="c1"> ' .
          '	<td align="right">' . $value['value'] . '</td> ' .
          '	<td nowrap colspan="2">' . $value['display'] . '</td> ' .
          '</tr> ';
      }

      $output['display'] .= '<tr class="c3"> ' .
        '	<td align="right">' . GMSG_TOTAL . '</td> ' .
        '	<td nowrap colspan="2">' . $auction_fees_box['display_amount'] . '</td> ' .
        '</tr> ';

      echo $output['display'];
    }
  ?>
  <?php echo $auction_terms_box; ?>
  <tr class="c5">
    <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
    <td colspan="2"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2"> <?php echo nav_btns_position(true, true); ?></td>
  </tr>
</table>
<br>
