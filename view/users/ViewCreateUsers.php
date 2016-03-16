<?php
if(empty($_SESSION['Login']) || $_SESSION['Admin']!=1  ){
    echo <<< EOT
        <form method="get" action=".">
            <fieldset>
                <legend>$label un utilisateur</legend>
                 <p>
                    <label for="id_mail">Mail :</label>
                    <input type="text" value="$m" name="mail" id="id_mail" $r/>
                </p>
                <p>
                    <label for="id_birth">Date de naissance </label>
                    <input type="date" value="$birth" name="birth" id="id_birth" $r/>
                </p>
                
                <p>
                    <label for="id_pwd">Mot de passe :</label>
                    <input type="password" name="pwd" id="id_pwd" required/>
                </p>
                <p>
                    <label for="id_pwd2">Retaper mot de passe :</label>
                    <input type="password" name="pwd2" id="id_pwd2" required/>
                </p>
                <input type="hidden" name="action" value="$act" />
                <input type="hidden" name="controller" value="Users" />                
                <p>
                    <input type="submit" value="$submit" />
                </p>

            </fieldset>
        </form>
EOT;
} else {
    echo <<< EOT
        <form method="get" action=".">
            <fieldset>
                <legend>$label un utilisateur</legend>
                 <p>
                    <label for="id_login">Mail :</label>
                    <input type="text" value="$m" name="mail" id="id_mail" $r/>
                </p>
                
                <p>
                    <label for="id_adm">Admin :</label>
                    <input type="text" value="$adm" name="admin" id="id_adm" required/>
                </p>
                <p>
                    <label for="id_pw">Mot de passe :</label>
                    <input type="password" name="pwd" id="id_pwd" required/>
                </p>
                <p>
                    <label for="id_pwd2">Retaper mot de passe :</label>
                    <input type="password" name="pwd2" id="id_pwd2" required/>
                </p>
                <input type="hidden" name="action" value="$act" />
                <input type="hidden" name="controller" value="Users" />                
                <p>
                    <input type="submit" value="$submit" />
                </p>

            </fieldset>
        </form>
EOT;
}

?>