<tr>
	<td>{$item->getName()}</td>
	<td>&pound;{$item->getPrice()|string_format:"%.2f"}</td>
	<td><a href="{$cScriptPath}/Billing?action=del&id={$item->getId()}&rt={$bid}">{message name="delete-item"}</a></td>
	<td><a href="{$cScriptPath}/Billing?action=edit&id={$item->getId()}&rt={$bid}">{message name="edit-item"}</a></td>
</tr>
