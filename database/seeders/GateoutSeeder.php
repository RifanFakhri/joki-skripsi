<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GateoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dc_gateout')->truncate();

        $data = $this->parseSqlData('dc_gateout');

        if (!empty($data)) {
            // Use array_chunk to insert in batches
            foreach (array_chunk($data, 100) as $chunk) {
                DB::table('dc_gateout')->insert($chunk);
            }
        }

        // Reset PostgreSQL auto-increment sequence
        if (config('database.default') === 'pgsql') {
            $maxId = DB::table('dc_gateout')->max('id');
            if ($maxId) {
                DB::statement("SELECT setval('dc_gateout_id_seq', ?)", [$maxId]);
            }
        }
    }

    private function parseSqlData(string $tableName): array
    {
        $sqlPath = base_path('discharging_cardsystem.sql');
        if (!file_exists($sqlPath)) {
            throw new \Exception("SQL file not found at: {$sqlPath}");
        }

        $content = file_get_contents($sqlPath);
        $startPattern = "INSERT INTO `{$tableName}` (";
        $data = [];
        $offset = 0;

        while (($startPos = strpos($content, $startPattern, $offset)) !== false) {
            $endColumnsPos = strpos($content, ") VALUES", $startPos);
            if ($endColumnsPos === false) {
                break;
            }

            $columnsStr = substr($content, $startPos + strlen($startPattern), $endColumnsPos - ($startPos + strlen($startPattern)));
            $columns = array_map(function ($col) {
                return trim($col, " `\t\n\r\0\x0B");
            }, explode(',', $columnsStr));

            $valuesStartPos = $endColumnsPos + strlen(") VALUES\n");
            
            $length = strlen($content);
            $rows = [];
            $currentRow = '';
            $inString = false;
            $escape = false;
            $inRow = false;
            $endOfStatementPos = $valuesStartPos;
            
            for ($i = $valuesStartPos; $i < $length; $i++) {
                $char = $content[$i];
                $endOfStatementPos = $i;
                
                if ($escape) {
                    if ($inRow) {
                        $currentRow .= $char;
                    }
                    $escape = false;
                    continue;
                }
                
                if ($char === '\\') {
                    if ($inRow) {
                        $currentRow .= $char;
                    }
                    $escape = true;
                    continue;
                }
                
                if ($char === "'") {
                    $inString = !$inString;
                    if ($inRow) {
                        $currentRow .= $char;
                    }
                    continue;
                }
                
                if (!$inString) {
                    if ($char === '(') {
                        $inRow = true;
                        $currentRow = '';
                        continue;
                    }
                    if ($char === ')') {
                        $inRow = false;
                        $rows[] = $this->parseSqlValues($currentRow);
                        $currentRow = '';
                        continue;
                    }
                    if ($char === ';') {
                        break;
                    }
                }
                
                if ($inRow) {
                    $currentRow .= $char;
                }
            }
            
            foreach ($rows as $row) {
                if (count($row) === count($columns)) {
                    $data[] = array_combine($columns, $row);
                }
            }
            
            $offset = $endOfStatementPos + 1;
        }
        
        return $data;
    }

    private function parseSqlValues(string $valuesString): array
    {
        $length = strlen($valuesString);
        $values = [];
        $current = '';
        $inString = false;
        $escape = false;
        
        for ($i = 0; $i < $length; $i++) {
            $char = $valuesString[$i];
            
            if ($escape) {
                $current .= $char;
                $escape = false;
                continue;
            }
            
            if ($char === '\\') {
                $escape = true;
                continue;
            }
            
            if ($char === "'") {
                $inString = !$inString;
                $current .= $char;
                continue;
            }
            
            if ($char === ',' && !$inString) {
                $values[] = trim($current);
                $current = '';
                continue;
            }
            
            $current .= $char;
        }
        $values[] = trim($current);
        
        return array_map(function($val) {
            $val = trim($val);
            if (strtoupper($val) === 'NULL') {
                return null;
            }
            if (str_starts_with($val, "'") && str_ends_with($val, "'")) {
                $unquoted = substr($val, 1, -1);
                return str_replace(["\\'", "\\\\"], ["'", "\\"], $unquoted);
            }
            return $val;
        }, $values);
    }
}
