import matplotlib.pyplot as plt
import japanize_matplotlib
import os

# 総数データ取得
with open(r"C:\xampp\htdocs\test\TXT\nanao_count.txt", 'r') as file:
    lines = file.readlines()

nanao = int(lines[0].strip())
nanao_w1 = int(lines[1].strip())
nanao_w2 = int(lines[2].strip())
nanao_w3 = int(lines[3].strip())
nanao_other = int(lines[4].strip())

labels = ['ゴミ', '人', '環境', 'その他']
sizes = [nanao_w1, nanao_w2, nanao_w3, nanao_other]

plt.figure(figsize=(5, 5))
plt.pie(sizes, labels=labels, autopct='%1.1f%%')
plt.legend(labels, loc="upper right")
plt.title('七尾市')
plt.tight_layout()
save_dir = "../png"
if not os.path.exists(save_dir):
    os.makedirs(save_dir)
plt.savefig('../png/nanao_graph.png', bbox_inches='tight', pad_inches=0.2)