<style>
	.image {
		width: 250px;
		height: 700px;
		float: left;
		padding: 10px;
		border: 1px solid black; 
		margin-right: 10px;
		margin-bottom: 10px;
	}
	.image img {
		width: 250px;
	}
	.description {
		font-size: 14px;
	}
</style>

<?php
	// Load config and setup endpoint
	require_once('./Wufoo-PHP-API-Wrapper/WufooApiWrapper.php');

	include "config.inc";
	$wrapper = new WufooApiWrapper($api_key, $subdomain);
	
	// List all form IDs uncomment the following lines to retrive a list of forms IDs.
	//$forms = $wrapper->getForms($identifier = null);
	//foreach ($forms as $form){
	//	echo $form->Name." {".$form->Hash.")\n";
	//}
	
	// Get details about the form
	//print_r($wrapper->getForms($identifier = $form_id)); //Identifier can be either a form hash or form URL.

	
	// Parse through form	
	
	$no_entries = $wrapper->getEntryCount($form_id); 
	$p = ceil($no_entries/25)-1;
	
	while ($p >= 0){
		$start = $p*25;
		//echo $p."\n";
		//echo $start."\n";
		$form = $wrapper->getEntries($form_id, 'forms', 'pageStart='.$start); 
		foreach ($form as $entry){
			//print_r($entry);	
			$name = $entry->Field1." ".$entry->Field2;
			$year = $entry->Field7;
			$description = $entry->Field8;
			preg_match('#\((.*?)\)#', $entry->Field4, $photo);
?>
		<div class="image">
			<a target="_blank" href="<?php echo $photo[1] ?>"><img src="<?php echo $photo[1] ?>"></a>
			<p><?php echo $name ?></p>
			<p><?php echo $year ?></p>
			<p class="description"><?php echo $description ?></p>
		</div>
<?php
		}
		$p = $p-1;
	}
?>