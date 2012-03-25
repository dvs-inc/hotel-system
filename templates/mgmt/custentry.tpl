<tr>
	<td>{$cust->getFirstName()}</td>
	<td>{$cust->getSurname()}</td>
	<td>{$cust->getEmail()}</td>
	<td><a href="{$cScriptPath}/Customers?action=edit&id={$cust->getId()}">{message name="edit-customer"}</a></td>
	<td><a href="{$cScriptPath}/Customers?action=del&id={$cust->getId()}">{message name="delete-customer"}</a></td>
	<td><a href="{$cScriptPath}/Customers?action=rsconfirm&id={$cust->getId()}">{message name="resend-mail-confirmation"}</a></td>
</tr>
