#!/bin/bash
CAMINHO="/var/www/novosalic"
HOST="HOST"
USERNAME="USERNAME"
PASS="PASSWORD"

chown -R www-data: $CAMINHO/

sed -i 's/$DIR_BANCO        = "bancos_AMBIENTE";/$DIR_BANCO      = "bancos_treinamento";/g' $CAMINHO/index.php
sed -i 's/$DIR_BANCOP     = "conexao_AMBIENTE";/$DIR_BANCOP     = "conexao_02";/g' $CAMINHO/index.php

sed -i "s/db.params.host = MudePorAmbiente/db.params.host = $HOST/g" $CAMINHO/application/configs/bancos_treinamento.ini
sed -i "s/db.params.username = MudePorAmbiente/db.params.username = $USERNAME/g" $CAMINHO/application/configs/bancos_treinamento.ini
sed -i "s/db.params.password = MudePorAmbiente/db.params.password = $PASS/g" $CAMINHO/application/configs/bancos_treinamento.ini

sed -i "s/db.params.host = MudePorAmbiente/db.params.host = $HOST/g" $CAMINHO/application/configs/config.ini
sed -i "s/db.params.username = MudePorAmbiente/db.params.username = $USERNAME/g" $CAMINHO/application/configs/config.ini
sed -i "s/db.params.password = MudePorAmbiente/db.params.password = $PASS/g" $CAMINHO/application/configs/config.ini
