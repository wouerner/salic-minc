# Roteiro de publicação de release

## Fluxo de desenvolvimento (simplificado)

Existem dois tipos de releases: hotfixes e features. Cada um segue um caminho diferente de desenvolvimento e publicação.

## 1) Hotfix

Hotfix é uma alteração emergencial a ser aplicada à produção. Envolve alguns commits no máximo e dificilmente dura mais que um dia.

Para criar uma hotfix, siga os passos abaixo:
```sh
    $ git checkout master
    $ git checkout -b 
    $ ... comite suas correções
    $ git push h/[numero da issue]/nome-da-correcao
```

**No github:**  

1. crie um pull request da branch h/[numero da issue]/nome-da-correcao para a **master** em https://github.com/culturagovbr/salic-minc/pulls 
2. solicite a revisão do código.   
3. com a revisão sendo aprovada:   
  * crie uma nova release em https://github.com/culturagovbr/salic-minc/releases (draft a new release)
  * preencha a release com:
      - número da tag
      - título da release
      - texto descritivo contendo modelo anterior do CHANGELOG (listagem de novas funcionalidades):
        Release 2.x.x
	* [FIX] Área do sistema: descrição da alteração (#3 [número da issue])
	(O identificador da issue deveria ser informado sempre que houver)

    Publicação da release
    * acesse os nós
    * cd /var/www/salic/app
    * git pull origin master
    
## 2) Feature

Para criar uma feature, siga os passos abaixo:
```
    $ git checkout develop
    $ git checkout -b f/[numero issue]/nome-da-feature
```
Comite suas correções.
```sh
    $ git checkout test
    $ git merge f/[numero issue]/nome-da-feature
    $ git push origin test
```
    
    ... homologação pelo cliente
   
**Se rejeitado:**
 * não sobe para develop e volta para o desenvolvimento da feature

**Se aceito:**
```sh    
    $ git checkout develop
    $ git merge feature-nome-da-feature
    $ git push origin develop
``` 
No github (irá publicar todas as features aprovadas e mergeadas na develop):
 * crie um pull request da feature develop em https://github.com/culturagovbr/salic-minc/pulls  
 * solicite o __pull request__  
 * crie uma nova release em https://github.com/culturagovbr/salic-minc/releases   (draft a new release)
 * preencha a release com:  
   - número da tag  
   - título da release  
   - texto descritivo contendo modelo anterior do CHANGELOG (listagem de novas funcionalidades)  
   - Release 2.x.x  
	* [FIX] Área do sistema: descrição da alteração (#3 [número da issue])  
	(O identificador da issue deveria ser informado sempre que houver)  

**Publicação da release**
  * acesse os nós:
 ```sh
 cd /var/www/salic/app
 git pull origin master
```
