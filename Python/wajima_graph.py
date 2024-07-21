import matplotlib.pyplot as plt
import japanize_matplotlib
import os

# 総数データ取得
with open(r"C:\xampp\htdocs\test\TXT\wajima_count.txt", 'r') as file:
    lines = file.readlines()

wajima = int(lines[0].strip())
wajima_w1 = int(lines[1].strip())
wajima_w2 = int(lines[2].strip())
wajima_w3 = int(lines[3].strip())
wajima_other = int(lines[4].strip())

labels = ['ゴミ', '人', '環境', 'その他']
sizes = [wajima_w1, wajima_w2, wajima_w3, wajima_other]

plt.figure(figsize=(5, 5))
plt.pie(sizes, labels=labels, autopct='%1.1f%%')
plt.legend(labels, loc="upper right")
plt.title('輪島市')
plt.tight_layout()
save_dir = "../png"
if not os.path.exists(save_dir):
    os.makedirs(save_dir)
plt.savefig('../png/wajima_graph.png', bbox_inches='tight', pad_inches=0.2)