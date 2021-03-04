const express = require('express')
const path = require('path')
const rp = require('request-promise')
const cheerio = require('cheerio')

const dotenv = require('dotenv')
dotenv.config({path: './.env'})

/*************************************APP BASE CONFIGS***********************************************/
const app = express()

/*************************************APP BASE CONFIGS***********************************************/

/*************************************Webscrapper***********************************************/

//const db = require("./database");

function processarDados(dados){
    //salva no banco de dados
    const db = require("./database");
    //console.log(JSON.stringify(dados))
    for(let i = 0; i < dados.length; i++){
        db.insertDB(dados[i])
        console.log(dados[i])
    }    
} 


/* SITE CULTURA INICIO*/

const optionsCultura = {
    uri: 'http://cultura.gov.br/categoria/noticias/',
    transform: function (body) {
        return cheerio.load(body)
    }
}

rp(optionsCultura)
.then(($) => {
  const dataToSave = []
  $('#posts-list > li').each((i, item) => {
 
    var dataPub = $(item).find('.details').text()
    const explodeDataPub1 = dataPub.split(', última modificação em')
    const explodeDataPub2 = explodeDataPub1[0].split('publicado em')
    const explodeDateAndHour = explodeDataPub2[1].split(' ')
    const explodeBars = explodeDateAndHour[1].split('/')    
    dataPub = explodeBars[2]+"-"+explodeBars[1]+"-"+explodeBars[0]

    if(typeof(explodeBars[2]) != "undefined"){
        let today = new Date().toISOString().slice(0, 10)

        const dados = {
            fonte: 'Cultura',
            url: $(item).find('h2').find('a').attr('href'),
            titulo: $(item).find('h2').find('a').text(),
            subtitulo: "",
            data_pub: dataPub,
            data_coleta: today,
            texto: $(item).find('p').text(),
            tags: $(item).find('.categories').find('a').text()
        }
    
        dataToSave.push(dados)
    }

  })
  
  processarDados(dataToSave)

})
.catch((err) => {
  console.log(err);
})

/* SITE CULTURA FIM*/

/* SITE CIDADANIA INICIO*/

const optionsCidadania = {
    uri: 'https://www.gov.br/cidadania/pt-br/noticias-e-conteudos/desenvolvimento-social/noticias-desenvolvimento-social',
    transform: function (body) {
        return cheerio.load(body)
    }
}

rp(optionsCidadania)
.then(($) => {
  const dataToSave = []
  $('#content-core > article').each((i, item) => {
 
    var dataPub = $(item).find('.summary-view-icon').eq(0).text()
    dataPub = dataPub.trim()
    //console.log('dataPub '+dataPub)

    const explodeBars = dataPub.split('/')    
    dataPub = explodeBars[2]+"-"+explodeBars[1]+"-"+explodeBars[0]

    const tags = [];
    var tagsCount = $(item).find('.keywords').find('span')
    
    for(let i = 0; i < tagsCount.length; i++){
        const tag = $(item).find('.keywords').find('span').eq(i).text()
        tags.push(tag.trim())
    }

    if(typeof(explodeBars[2]) != "undefined"){
        let today = new Date().toISOString().slice(0, 10)

        const dados = {
            fonte: 'Cidadania',
            url: $(item).find('.tileHeadline').find('a').attr('href'),
            titulo: $(item).find('.tileHeadline').find('a').text(),
            subtitulo: "",
            data_pub: dataPub,
            data_coleta: today,
            texto: $(item).find('.tileBody').find('.description').text(),
            tags: JSON.stringify(tags)
        }
    
        dataToSave.push(dados)
    }

  })
  
  processarDados(dataToSave)

})
.catch((err) => {
  console.log(err);
})

/* SITE CIDADANIA FIM*/

/*************************************Webscrapper***********************************************/

app.listen(3002, () => {
    console.log('Server collect running on port 3002')
})