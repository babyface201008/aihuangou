<template>
	<div class="mcyArticle">
<<<<<<< HEAD
         <Table border :columns="columns7" :data="data6"></Table>
=======
		<table>
			<th></th>
		</table>
>>>>>>> 4acadde198387e7fe2d677a97aec0927718710a5
	</div>
</template>

<script>
	export default {
		data () {
			return {
				breadcrumbs : [
					{ title : '文章',href:'/#/article'},
				],
                columns7: [
                      { 
                        title : '文章ID',
                        key: 'article_id',
                      },
                      {
                          title : '文章标题',
                          key: 'article_title',
                      },
                      {
                          title : '标签',
                          key: 'article_tags'
                      },
                      {
                          title: '操作',
                          key: 'operator',
                          width:'150px',
                          align:'center',
                          render: (h, params) => {
                              return h('div', [
                              h('Button', {
                                  props: {
                                      type: 'primary',
                                      size: 'small'
                                  },
                                  style: {
                                      marginRight: '5px'
                                  },
                                  on: {
                                      click: () => {
                                          this.show(params.index)
                                      }
                                  }
                              }, '查看'),
                              h('Button', {
                                  props: {
                                      type: 'error',
                                      size: 'small'
                                  },
                                  on: {
                                      click: () => {
                                          this.remove(params.index)
                                      }
                                  }
                              }, '删除')
                            ]);
                      }
                ],
                data6: [
                    {
                        article_id :'1',
                        article_title : 'article1',
                        article_tags : 'welkin,firesky',
                    }
                    ]
			}
		},
		methods: {

		},
		created () {
			this.$store.dispatch('updateRoute',this.breadcrumbs);
		}
	}
</script>
