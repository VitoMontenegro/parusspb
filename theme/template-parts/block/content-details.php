<?php
$options = get_fields( 'option');
$fields = get_fields();
?>
<div class="self-stretch justify-start items-start gap-8 inline-flex">
	<div class="grow shrink basis-0 text-gray-500 text-base font-normal font-['Inter']">Реквизиты:<br/><?php echo $options['info'];  ?></div>
</div>
