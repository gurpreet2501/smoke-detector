<html>
    <body>
    	<table border="1" cellpadding="12" cellpadding="2">
	    	<tr>
                <th>
                    Date
                </th>
		    	<th>
		    		Log
		    	</th>
	    	</tr>    		
	    	<?php foreach($logs as $log): ?>
        		<tr>
                    <td>
                        <?=$log->datetime?>
                    </td>
        			<td>
        				<?=nl2br($log->message)?>
                    </td>
        		</tr>
        	<?php endforeach; ?>
    	</table>

    </body>
</html>