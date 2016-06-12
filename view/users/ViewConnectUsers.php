<?php
echo <<< EOT
        <form method="post" action=".">
            <fieldset class="form-group">
                <div class="input-group">
                    <label for="id_mail">Mail :</label>
                    <input type="text" value="$m"  placeholder="johnsmith@gmail.com" name="mail" id="mail" required/>
                </div>
                <div class="input-group">
                    <label for="id_pw">Mot de passe :</label>
                    <input type="password" placeholder="********" value="$ConnectPassword" name="ConnectPassword" id="id_pwd" required/>
                </div>
                
                <input type="hidden" name="action" value="$act" />
                <input type="hidden" name="controller" value="Users" />                
                
                <div class="input-group">
                    <input type="submit" value="$submit" />
                </div>
        
            </fieldset>
        </form>
EOT;
?>