<?php
if ($pedidoAjax) {
    require_once "../config/configAPP.php";
} else {
    require_once "./config/configAPP.php";
}

class DbModel
{
    public static $conn;

    protected function connection($siscontrat = false)
    {
        if (!isset(self::$conn)) {
            if (!$siscontrat) {
                self::$conn = new PDO(SGDB1, USER1, PASS1, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            } else {
                self::$conn = new PDO(SGDB2, USER2, PASS2, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            }
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }

    /**
     * <p>Função para inserir um registro no banco de dados </p>
     * @param string $table
     * <p>Tabela do banco de dados</p>
     * @param array $data
     * <p>Dados a serem inseridos</p>
     * @param bool $siscontrat
     * <p><strong>FALSE</strong> por padrão. Quando <strong>TRUE</strong>, faz a consulta no banco de dados do sistema <i>SISCONTRAT</i></p>
     * @return bool|PDOStatement
     */
    protected function insert($table, $data, $siscontrat = false)
    {
        $pdo = self::connection($siscontrat);
        $fields = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $statement = $pdo->prepare($sql);
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value, PDO::PARAM_STR);
        }
        $statement->execute();

        return $statement;
    }

    // Método para update

    /**
     * <p>Atualiza os dados do registro especificado</p>
     * @param string $table
     * <p>Tabela do banco de dados</p>
     * @param array $data
     * <p>Dados a serem inseridos</p>
     * @param int $id
     * <p>ID do registro a ser atualizado</p>
     * @param bool $siscontrat
     * <p><strong>FALSE</strong> por padrão. Quando <strong>TRUE</strong>, faz a consulta no banco de dados do sistema <i>SISCONTRAT</i></p>
     * @return bool|PDOStatement
     */
    protected function update($table, $data, $id, $siscontrat = false)
    {
        $pdo = self::connection($siscontrat);
        $new_values = "";
        foreach ($data as $key => $value) {
            $new_values .= "$key=:$key, ";
        }
        $new_values = substr($new_values, 0, -2);
        $sql = "UPDATE $table SET $new_values WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id, PDO::PARAM_STR);
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value, PDO::PARAM_STR);
        }
        $statement->execute();

        return $statement;
    }

    // Método para update especial

    /**
     * <p>Atualiza os dados de um registro onde o campo buscado não é o <i>id</i></p>
     * @param string $table
     * <p>Tabela do banco de dados</p>
     * @param array $data
     * <p>Dados a serem inseridos</p>
     * @param array $campo
     * <p>Campo pelo qual deve ser pesquisado o registro</p>
     * @param array|string $campo_id
     * <p><i>Valor</i> do registro a ser atualizado</p>
     * @param bool $siscontrat
     * <p><strong>FALSE</strong> por padrão. Quando <strong>TRUE</strong>, faz a consulta no banco de dados do sistema <i>SISCONTRAT</i></p>
     * @return bool|PDOStatement
     */
    protected function updateEspecial($table, $data, $campo, $campo_id, $siscontrat = false)
    {
        $pdo = self::connection($siscontrat);
        $new_values = "";
        foreach ($data as $key => $value) {
            $new_values .= "$key=:$key, ";
        }
        $new_values = substr($new_values, 0, -2);
        $sql = "UPDATE $table SET $new_values WHERE $campo = :$campo";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":$campo", $campo_id, PDO::PARAM_STR);
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value, PDO::PARAM_STR);
        }
        $statement->execute();

        return $statement;
    }

    /**
     * <p>Atualiza os dados de um registro onde o campo buscado não é o <i>id</i></p>
     * @param string $table
     * <p>Tabela do banco de dados</p>
     * @param array $data
     * <p>Dados a serem inseridos</p>
     * @param array $campo
     * <p>Campo pelo qual deve ser pesquisado o registro</p>
     * @param array|string $campo_id
     * <p><i>Valor</i> do registro a ser atualizado</p>
     * @param bool $siscontrat
     * <p><strong>FALSE</strong> por padrão. Quando <strong>TRUE</strong>, faz a consulta no banco de dados do sistema <i>SISCONTRAT</i></p>
     * @return bool|PDOStatement
     */
    protected function updateEspecialPublicado($table, $data, $campo, $campo_id, $siscontrat = false)
    {
        $pdo = self::connection($siscontrat);
        $new_values = "";
        foreach ($data as $key => $value) {
            $new_values .= "$key=:$key, ";
        }
        $new_values = substr($new_values, 0, -2);
        $sql = "UPDATE $table SET $new_values WHERE publicado = '1' AND $campo = :$campo";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":$campo", $campo_id, PDO::PARAM_STR);
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value, PDO::PARAM_STR);
        }
        $statement->execute();

        return $statement;
    }

    // Método para apagar (despublicar)

    /**
     * <p>Método para despublicar o registro especificado</p>
     * @param $table
     * <p>Tabela do banco de dados</p>
     * @param $id
     * <p>ID do registro que deve ser despublicado</p>
     * @param bool $siscontrat
     * <p><strong>FALSE</strong> por padrão. Quando <strong>TRUE</strong>, faz a consulta no banco de dados do sistema <i>SISCONTRAT</i></p>
     * @return bool|PDOStatement
     */
    protected function apaga($table, $id, $siscontrat = false)
    {
        $pdo = self::connection($siscontrat);
        $sql = "UPDATE $table SET publicado = 0 WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();

        return $statement;
    }

    /**
     * <p>Método para despublicar o registro especificado onde a chave primária não é chamadad de <i>ID</i></p>
     * @param $table
     * <p>Tabela do banco de dados</p>
     * @param $campo
     * @param $campo_id
     * @param false $siscontrat
     * @return bool|PDOStatement
     */
    protected function apagaEspecial($table, $campo, $campo_id, $siscontrat = false)
    {
        $pdo = self::connection($siscontrat);
        $sql = "UPDATE $table SET publicado = 0 WHERE $campo = :$campo";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":$campo", $campo_id);
        $statement->execute();

        return $statement;
    }

    /**
     * <p>Este método <strong>DELETA</strong> o registro selecionado do sistema. <strong>ATENÇÃO! Este processo não tem reversão</strong></p>
     * @param $table
     * <p>Tabela do banco de dados</p>
     * @param $campo
     * <p>Campo pelo qual deve ser pesquisado o registro</p>
     * @param $campo_id
     * <p><i>Valor</i> do registro que será <strong>EXCLUÍDO</strong></p>
     * @param bool $siscontrat
     * <p><strong>FALSE</strong> por padrão. Quando <strong>TRUE</strong>, faz a consulta no banco de dados do sistema <i>SISCONTRAT</i></p>
     * @return bool|PDOStatement
     */
    protected function deleteEspecial($table, $campo, $campo_id, $siscontrat = false)
    {
        $pdo = self::connection($siscontrat);
        $sql = "DELETE FROM $table WHERE $campo = :$campo";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":$campo", $campo_id, PDO::PARAM_STR);
        $statement->execute();

        return $statement;
    }

    public function consultaSimples($consulta, $siscontrat = false)
    {
        $pdo = self::connection($siscontrat);
        $statement = $pdo->prepare($consulta);
        $statement->execute();
        self::$conn = null;

        return $statement;
    }

    /**
     * Método para pegar a informação
     * @param $table
     * @param $id
     * @return bool|PDOStatement
     */
    protected function getInfo($table, $id, $siscontrat = false)
    {
        $pdo = self::connection($siscontrat);
        $sql = "SELECT * FROM $table WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
        self::$conn = null;

        return $statement;
    }

    /**
     * Método para pegar a informação declarando o campo para busca
     * @param $table
     * @param $id
     * @return bool|PDOStatement
     */
    protected function getInfoEspecial($table, $campo, $campo_id, $siscontrat = false)
    {
        $pdo = self::connection($siscontrat);
        $sql = "SELECT * FROM $table WHERE $campo = :campo_id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":campo_id", $campo_id);
        $statement->execute();
        self::$conn = null;

        return $statement;
    }

    // Lista publicados
    protected function listaPublicado($table, $id = null, $siscontrat = false)
    {
        if (!empty($id)) {
            $filtro_id = "AND id = :id";
        } else {
            $filtro_id = "";
        }
        $pdo = self::connection($siscontrat);
        $sql = "SELECT * FROM $table WHERE publicado = 1 $filtro_id ORDER BY 2";
        $statement = $pdo->query($sql);
        $statement->execute();
        self::$conn = null;

        return $statement->fetchAll();
    }
}