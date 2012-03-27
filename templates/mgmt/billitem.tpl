<tr>
	<td>{$item->getName()}</td>
	<td>&pound;{$item->getPrice()|string_format:"%.2f"}</td>
	<td><a href="{$cScriptPath}/Billing{$item->getId()}">{message name="delete-item"}</a></td>
</tr>
