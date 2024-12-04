# # import os
# # import pandas as pd
# # import mysql.connector
# # from mysql.connector import Error

# # # MySQL 数据库连接配置
# # db_config = {
# #     'host': 'localhost',
# #     'user': 'root',
# #     'password': 'password',
# #     'database': 'movie_forum'
# # }

# # # CSV 文件存放路径
# # csv_folder_path = 'C:\\Users\\刘芳宜\\Desktop\\web_database_development\\archive'


# # # 创建 MySQL 连接
# # def create_connection():
# #     try:
# #         conn = mysql.connector.connect(**db_config)
# #         if conn.is_connected():
# #             print("连接到 MySQL 数据库成功！")
# #         return conn
# #     except Error as e:
# #         print(f"数据库连接失败: {e}")
# #         return None

# # # 插入数据到数据库表
# # def insert_data_into_db(year, data):
# #     try:
# #         connection = create_connection()
# #         if connection is None:
# #             return
        
# #         cursor = connection.cursor()
# #         # 构建插入 SQL 语句
# #         insert_query = """
# #         INSERT INTO country_rank (year, `rank`, country, region, documents, citable_documents, citations, self_citations, citations_per_document, h_index)
# #         VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s);
# #         """
        
# #         # 遍历 DataFrame 行，并插入数据
# #         for row in data.itertuples(index=False, name=None):
# #             cursor.execute(insert_query, (year, *row))
        
# #         connection.commit()  # 提交事务
# #         print(f"年份 {year} 的数据插入成功！")
    
# #     except Error as e:
# #         print(f"插入数据时发生错误: {e}")
    
# #     finally:
# #         if connection.is_connected():
# #             cursor.close()
# #             connection.close()

# # # 读取并插入 CSV 文件数据
# # def load_csv_data_and_insert():
# #     for year in range(1997, 2022):  # 从1997到2021
# #         file_path = os.path.join(csv_folder_path, f"scimagojr country rank {year}.csv")
        
# #         if os.path.exists(file_path):
# #             print(f"正在处理 {year} 年的 CSV 文件...")
            
# #             # 读取 CSV 文件
# #             data = pd.read_csv(file_path)
            
# #             # 插入数据到数据库
# #             insert_data_into_db(year, data)
# #         else:
# #             print(f"文件 {year} 年的 CSV 不存在，跳过该年。")

# # # 运行脚本
# # if __name__ == "__main__":
# #     load_csv_data_and_insert()
# import pandas as pd
# import mysql.connector
# from mysql.connector import Error

# # 连接到数据库
# def create_connection():
#     try:
#         connection = mysql.connector.connect(
#             host='localhost',  # 或者你数据库的主机地址
#             database='movie_forum',  # 使用你要导入的数据库
#             user='root',  # 数据库用户名
#             password='password'  # 数据库密码
#         )
#         if connection.is_connected():
#             print("连接到数据库成功")
#         return connection
#     except Error as e:
#         print(f"数据库连接错误: {e}")
#         return None

# # 导入CSV数据并插入到数据库中
# def load_csv_data_and_insert(csv_file_path):
#     # 读取CSV文件
#     data = pd.read_csv(csv_file_path)
    
#     # 确保所有需要的列存在
#     required_columns = ['title', 'abstract', 'published', 'authors', 'url']
#     for column in required_columns:
#         if column not in data.columns:
#             print(f"缺少列: {column}")
#             return
    
#     # 建立数据库连接
#     connection = create_connection()
#     if connection is None:
#         return
    
#     cursor = connection.cursor()
    
#     # 插入数据
#     for _, row in data.iterrows():
#         try:
#             cursor.execute("""
#                 INSERT INTO arxiv_papers (title, abstract, published, authors, url)
#                 VALUES (%s, %s, %s, %s, %s)
#             """, (row['title'], row['abstract'], row['published'], row['authors'], row['url']))
        
#             # 提交每次插入
#             connection.commit()
#             print(f"插入成功: {row['title']}")
#         except Error as e:
#             print(f"插入数据失败: {e}")
#             connection.rollback()
    
#     # 关闭数据库连接
#     cursor.close()
#     connection.close()

# # 文件路径
# csv_file_path = 'C:\\Users\\刘芳宜\\Desktop\\web_database_development\\archive\\arxiv_papers.csv'

# # 调用函数导入数据
# load_csv_data_and_insert(csv_file_path)
import pandas as pd
from sqlalchemy import create_engine
from sqlalchemy.exc import SQLAlchemyError

# MySQL连接配置
db_config = {
    'host': 'localhost',  # 数据库主机
    'user': 'root',  # 数据库用户名
    'password': 'password',  # 数据库密码
    'database': 'movie_forum'  # 数据库名称
}

# CSV文件路径
csv_file = r'C:\Users\刘芳宜\Desktop\web_database_development\archive\all_ai_tool.csv'

# 使用Pandas读取CSV文件
data = pd.read_csv(csv_file)

# 打印前几行数据，确认正确读取
print(data.head())

# 创建数据库连接
try:
    engine = create_engine(f'mysql+mysqlconnector://{db_config["user"]}:{db_config["password"]}@{db_config["host"]}/{db_config["database"]}')
    
    # 导入数据到MySQL
    data.to_sql('all_ai_tool', con=engine, if_exists='append', index=False, dtype={
        'AI Tool Name': 'VARCHAR(255)',
        'Description': 'TEXT',
        'Free/Paid/Other': 'VARCHAR(255)',
        'Useable For': 'TEXT',
        'Charges': 'VARCHAR(255)',
        'Review': 'TEXT',
        'Tool Link': 'VARCHAR(255)',
        'Major Category': 'VARCHAR(255)'
    })
    
    print("CSV file has been successfully imported into the database!")
except SQLAlchemyError as e:
    print(f"Error while importing CSV data into database: {e}")
except Exception as e:
    print(f"An error occurred: {e}")
