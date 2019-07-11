<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class BackupSigart
{
    private static $db_name;
    private static $not_table = [
        'migrations'
    ];

    public static function backupTables() {
        try{
            /*
            * Tables of export
            */
            static::$db_name    = env('DB_DATABASE', '');
            $dictionary         = [];
            $sqlTables          = "SELECT 
                                        t1.TABLE_NAME AS 'tableName', 
                                        t1.TABLE_COMMENT AS 'tableDescription'
                                    FROM INFORMATION_SCHEMA.TABLES AS t1 
                                    WHERE t1.TABLE_SCHEMA='" . static::$db_name ."' 
                                    ORDER BY t1.TABLE_NAME";
            
            $showTables         = DB::select( $sqlTables );
            foreach( $showTables as $showtable ){
                if( ! in_array( $showtable->tableName, static::$not_table ) ) {
                    $detail = self::getDetailTable( $showtable->tableName );
                    $dictionary[] = [
                        'name'          => $showtable->tableName,
                        'description'   => $showtable->tableDescription,
                        'columns'       => $detail['columns'],
                        'relationships' => $detail['relationships']
                    ];
                }
            }

            if( ! empty( $dictionary ) && is_array( $dictionary ) && count( $dictionary ) > 0 ){
                return $dictionary;
            }else{
                return [
                    'error' => 'No se encontró ninguna BD.'
                ];
            }

        } catch( Exception $e ){
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public static function getDetailTable( $table ){
        try {
            $columns        = [];
            $allColumns     = [];

            $sql    = "SELECT
                        t1.COLUMN_NAME AS columnName,
                        t1.COLUMN_DEFAULT AS columnDefault,
                        t1.IS_NULLABLE AS columnIsNullable,
                        t1.DATA_TYPE AS columnDataType,
                        IFNULL(t1.NUMERIC_PRECISION,
                        t1.CHARACTER_MAXIMUM_LENGTH) AS columnLength,
                        t1.COLUMN_COMMENT AS columnComment
                    FROM 
                        INFORMATION_SCHEMA.COLUMNS t1
                    WHERE 
                        t1.TABLE_SCHEMA = '" . static::$db_name . "' AND
                        t1.TABLE_NAME = '{$table}'
                    ORDER BY
                        t1.ORDINAL_POSITION";
            $cols   = DB::select( $sql );
            foreach( $cols as $col ) {
                $columns[] = [
                    'name'          => $col->columnName,
                    'default'       => $col->columnDefault,
                    'isNullable'    => $col->columnIsNullable,
                    'dataType'      => $col->columnDataType,
                    'length'        => $col->columnLength,
                    'comment'       => $col->columnComment
                ];
                
                $allColumns[]   = $col->columnName;
            }

            $relationships  = self::getRelationships( $table, $allColumns );

            return [
                'columns'       => $columns,
                'relationships' => $relationships
            ];

        } catch( Exception $e ) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public static function getRelationships( $table, $columns ){
        try{
            $relationships = [];

            if( empty( $table ) ){
                return [
                    'error' => 'El nombre de la tabla es requerido.'
                ];
            }

            if( ! is_array( $columns ) || count( $columns ) == 0 ){
                return [
                    'error' => 'No hay columnas.'
                ];
            }

            $columnsString = '\'' . implode( '\', \'', $columns ) . '\'';

            $sql = "SELECT
                        t1.CONSTRAINT_TYPE AS constraintType,
                        t2.COLUMN_NAME AS columnName,
                        t2.REFERENCED_TABLE_NAME AS referencedTableName,
                        t2.REFERENCED_COLUMN_NAME AS referencedColumnName
                    FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS t1
                        LEFT JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE t2
                        ON t1.CONSTRAINT_CATALOG = t2.CONSTRAINT_CATALOG
                        AND t1.CONSTRAINT_SCHEMA = t2.CONSTRAINT_SCHEMA
                        AND t1.CONSTRAINT_NAME = t2.CONSTRAINT_NAME
                    WHERE
                        t1.TABLE_SCHEMA = '" . static::$db_name . "' AND
                        t1.TABLE_NAME = '{$table}' AND
                        t2.COLUMN_NAME IN ( {$columnsString} )
                    ORDER BY
                        t1.CONSTRAINT_TYPE DESC;";
            $cols   = DB::select( $sql );
            foreach( $cols as $col ) {
                if( $col->constraintType == 'PRIMARY KEY' ){
                    $key = array_search( $col->columnName, array_column( $relationships, 'columnName' ));
                    
                    if( is_bool( $key ) && $key == false ){
                        $relationships[] = $col;
                    }
                }
                if( $col->referencedTableName != '' ){
                    $relationships[] = $col;
                }
            }

            return $relationships;

        }catch( Exception $e ){
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
