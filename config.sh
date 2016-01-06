#!/bin/bash
HOST="HOST"
USERNAME="USERNAME"
PASS="PASSWORD"

cp -av application/configs/bancos_treinamento.ini-exemplo application/configs/bancos_treinamento.ini
cp -av application/configs/config.ini-exemplo application/configs/config.ini


sed -i 's/$DIR_BANCO        = "bancos_AMBIENTE";/$DIR_BANCO      = "bancos_treinamento";/g' index.php
sed -i 's/$DIR_BANCOP     = "conexao_AMBIENTE";/$DIR_BANCOP     = "conexao_02";/g' index.php

sed -i "s/db.params.host = MudePorAmbiente/db.params.host = $HOST/g" application/configs/bancos_treinamento.ini
sed -i "s/db.params.username = MudePorAmbiente/db.params.username = $USERNAME/g" application/configs/bancos_treinamento.ini
sed -i "s/db.params.password = MudePorAmbiente/db.params.password = $PASS/g" application/configs/bancos_treinamento.ini

sed -i "s/db.params.host = MudePorAmbiente/db.params.host = $HOST/g" application/configs/config.ini
sed -i "s/db.params.username = MudePorAmbiente/db.params.username = $USERNAME/g" application/configs/config.ini
sed -i "s/db.params.password = MudePorAmbiente/db.params.password = $PASS/g" application/configs/config.ini
