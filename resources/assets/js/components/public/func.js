let URL_BASE = 'http://' + window.location.host + '/'

const func = {
	getfunc () {
		return "welkin is func for you";
	},
	getRiChangNav(){
		let url = 'api/getRiChangNav';
		return axios.get(URL_BASE + url)
		.then((res) => {
			if(res.data.ret == 0)
			{
			 return  res.data.data;
			}else{
              return false
          }
      }).catch((err) => {
      	console.log(err)
      });
	},
	mcyLoginCheck(username,password){
		console.log('mcy login check start');
		console.log(this.$router);
		return axios.post(URL_BASE + 'api/mcyLogin')
		.then( (res) => {
			if (res.data.ret == 0) 
			{
				return true;
			}else{
				return false;
			}
		}).catch((err) => {
			console.log('err');
			console.log('error',err);
		});
	}
}

export default func