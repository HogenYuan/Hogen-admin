2020.9.24
1. 优化makeResource一键生成后端代码包
    * 添加migration文件
    * 添加通过扫描同名数据表自动生成migration、model、resource字段
    * 去掉指定model字段
    * 可自定义多级目录和文件路径，适应不同的项目路径环境
    * 通过手动配置决定是否使用filter和创建基类文件
2. 去掉filter层，把filter整合到model内通过trait引入
3. 添加Exception异常处理常用包
4. 添加Service层，主做数据的逻辑处理
5. 添加ApiResponse底层包
    * resource习惯改成propXxx
    * composer.json添加自动加载
6. Vue.config.js
    * 添加自定义端口和api接口
    * 添加.env文件

5. TODO 
   * resource、model的stub文件还需要根据项目代码格式修改
---
2020.9.23
1. 添加Area、Back、Table、Upload、RouteTabs组件
---
2020.9.22
1. 添加search、DatePicker、InputNumber组件
2. 添加constants.js和config.js
3. 添加helpers.js