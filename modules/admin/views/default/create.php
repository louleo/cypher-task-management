<div class="user-default-create">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <form action="/user/create">
        <table>
            <tr>
                <td>
                    User Name
                </td>
                <td>
                    <input type="text" name="user_name">
                </td>
            </tr>
            <tr>
                <td>
                    User Number
                </td>
                <td>
                    <input type="text" name="user_number">
                </td>
            </tr>
            <tr>
                <td>
                    Password
                </td>
                <td>
                    <input type="password" name="user_password">
                </td>
            </tr>
            <tr>
                <td>
                    Date of Birth
                </td>
                <td>
                    <input type="date" name="user_dob">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Submit">
                </td>
            </tr>
        </table>
    </form>
</div>
