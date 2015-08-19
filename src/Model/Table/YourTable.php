<?php
//Adiciona a função abaixo no seu arquivo 
public function validationDefault(Validator $validator)
    {
      //supondo que o campo no seu banco de dados se chama cpf
       $validator
            ->add('cpf','custom',
                ['rule'=>
                    function($cpf)
                    {   
                         // Verifica se um número foi informado
                        if(empty($cpf)) {
                            return false;
                        }
                     
                        // Elimina possivel mascara
                        $cpf = ereg_replace('[^0-9]', '', $cpf);
                        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
                         
                        // Verifica se o numero de digitos informados é igual a 11 
                        if (strlen($cpf) != 11) {
                            return false;
                        }
                        // Verifica se nenhuma das sequências invalidas abaixo foi digitada
                        else if ($cpf == '00000000000' || 
                            $cpf == '11111111111' || 
                            $cpf == '22222222222' || 
                            $cpf == '33333333333' || 
                            $cpf == '44444444444' || 
                            $cpf == '55555555555' || 
                            $cpf == '66666666666' || 
                            $cpf == '77777777777' || 
                            $cpf == '88888888888' || 
                            $cpf == '99999999999') {
                            return false;
                         // Calcula os digitos verificadores para verificar se o cpf é valido
                         } else {   
                             
                            for ($t = 9; $t < 11; $t++) {
                                 
                                for ($d = 0, $c = 0; $c < $t; $c++) {
                                    $d += $cpf{$c} * (($t + 1) - $c);
                                }
                                $d = ((10 * $d) % 11) % 10;
                                if ($cpf{$c} != $d) {
                                    return false;
                                }
                            }
                     
                            return true;
                        }
                        
                    },
                    // Caso retorne falso ele vai retornar uma mensagem falando que é inválido
                    'message'=>'CPF Inválido'
                ])
    }
    
?>
