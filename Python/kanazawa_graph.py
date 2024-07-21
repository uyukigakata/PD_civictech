import matplotlib.pyplot as plt
import japanize_matplotlib
import os

# 総数データ取得
with open(r"C:\xampp\htdocs\test\TXT\kanazawa_count.txt", 'r') as file:
    lines = file.readlines()

kanazawa = int(lines[0].strip())
kanazawa_w1 = int(lines[1].strip())
kanazawa_w2 = int(lines[2].strip())
kanazawa_w3 = int(lines[3].strip())
kanazawa_other = int(lines[4].strip())

labels = ['ゴミ', '人', '環境', 'その他']
sizes = [kanazawa_w1, kanazawa_w2, kanazawa_w3, kanazawa_other]

plt.figure(figsize=(5, 5))
plt.pie(sizes, labels=labels, autopct='%1.1f%%')
plt.legend(labels, loc="upper right")
plt.title('金沢市')
plt.tight_layout()
save_dir = "../png"
if not os.path.exists(save_dir):
    os.makedirs(save_dir)
plt.savefig('../png/kanazawa_graph.png', bbox_inches='tight', pad_inches=0.2)